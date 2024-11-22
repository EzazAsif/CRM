<?php
require_once('../config.php');
class Master extends DBConnection {
    private $settings;
    private $memcache;
    
    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        
        // Initialize Memcache
        $this->memcache = new Memcached();
        $this->memcache->addServer('localhost', 3306);  // Adjust the server and port if needed
        
        parent::__construct();
    }
    
    public function __destruct() {
        parent::__destruct();
    }
    
    // Load service categories with Memcached
    public function load_service_category() {
        $cache_key = "service_categories";
        $data = $this->memcache->get($cache_key);
        
        if ($data === false) {
            $qry = $this->conn->query("SELECT * FROM services_category ORDER BY category ASC");
            $data = array();
            while ($row = $qry->fetch_assoc()) {
                $row['description'] = strip_tags(stripslashes($row['description']));
                $data[] = $row;
            }
            $this->memcache->set($cache_key, $data, 3600);  // Cache for 1 hour
        }
        
        $resp['status'] = 'success';
        $resp['data'] = $data;
        return json_encode($resp);
    }

    // Load services with Memcached
    public function load_service() {
        $cache_key = "services";
        $data = $this->memcache->get($cache_key);
        
        if ($data === false) {
            $qry = $this->conn->query("SELECT s.*, c.category FROM services s 
                                       INNER JOIN services_category c ON c.id = s.category_id 
                                       ORDER BY s.service ASC");
            $data = array();
            while ($row = $qry->fetch_assoc()) {
                $row['description'] = strip_tags(stripslashes($row['description']));
                $row['img_path'] = validate_image($row['img_path']);
                $data[] = $row;
            }
            $this->memcache->set($cache_key, $data, 3600);  // Cache for 1 hour
        }
        
        $resp['status'] = 'success';
        $resp['data'] = $data;
        return json_encode($resp);
    }

    // Load tickets with Memcached
    public function load_tickets() {
        extract($_POST);
        $cache_key = "tickets_" . md5($search);
        $data = $this->memcache->get($cache_key);
        
        if ($data === false) {
            $stmt = $this->conn->prepare("SELECT t.*, s.service, c.category FROM tickets t 
                                          INNER JOIN services s ON t.service_id = s.id 
                                          INNER JOIN services_category c ON c.id = s.category_id 
                                          WHERE t.user_id = ? AND t.user_created = 'user' 
                                          ORDER BY date(date_created) DESC");
            $stmt->bind_param('i', $this->settings->userdata('id'));
            $stmt->execute();
            $result = $stmt->get_result();
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $row['description'] = strip_tags(stripslashes($row['description']));
                $data[] = $row;
            }
            $this->memcache->set($cache_key, $data, 3600);  // Cache for 1 hour
        }
        
        $resp['status'] = 'success';
        $resp['data'] = $data;
        return json_encode($resp);
    }

    // Load comments for a specific ticket with Memcached
    public function load_comments() {
        extract($_POST);
        $cache_key = "comments_ticket_{$id}";
        $data = $this->memcache->get($cache_key);
        
        if ($data === false) {
            $stmt = $this->conn->prepare("SELECT * FROM ticket_comment WHERE ticket_id = ? ORDER BY date(date_created) DESC");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $row['comment'] = strip_tags(stripslashes($row['comment']));
                $data[] = $row;
            }
            $this->memcache->set($cache_key, $data, 3600);  // Cache for 1 hour
        }
        
        $resp['status'] = 'success';
        $resp['data'] = $data;
        return json_encode($resp);
    }

    // Save category data with Memcached invalidation
    public function save_category() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id'))) {
                if ($k == 'description') $v = addslashes($v);
                if (!empty($data)) $data .= " , ";
                $data .= " {$k} = '{$v}' ";
            }
        }
        $stmt = $this->conn->prepare("SELECT * FROM services_category WHERE category = ? AND id != ?");
        $stmt->bind_param('si', $category, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp['status'] = 'duplicate';
        } else {
            if (empty($id)) {
                $stmt = $this->conn->prepare("INSERT INTO services_category SET $data");
            } else {
                $stmt = $this->conn->prepare("UPDATE services_category SET $data WHERE id = ?");
                $stmt->bind_param('i', $id);
            }
            $stmt->execute();
            $this->memcache->delete("service_categories");  // Invalidate cache
            $resp['status'] = 'success';
        }
        return json_encode($resp);
    }

    // Delete a service category with Memcached invalidation
    public function delete_service_category() {
        extract($_POST);
        $stmt = $this->conn->prepare("DELETE FROM services_category WHERE id = ?");
        $stmt->bind_param('i', $id);
        $delete = $stmt->execute();
        $delete2 = $this->conn->query("DELETE FROM services WHERE category_id = $id");
        if ($delete && $delete2) {
            $this->memcache->delete("service_categories");  // Invalidate cache
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'error';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    // Save service data with Memcached invalidation
    public function save_service() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id'))) {
                if ($k == 'description') $v = addslashes($v);
                if (!empty($data)) $data .= " , ";
                $data .= " {$k} = '{$v}' ";
            }
        }
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE service = ? AND id != ?");
        $stmt->bind_param('si', $service, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp['status'] = 'duplicate';
        } else {
            if (empty($id)) {
                $stmt = $this->conn->prepare("INSERT INTO services SET $data");
            } else {
                $stmt = $this->conn->prepare("UPDATE services SET $data WHERE id = ?");
                $stmt->bind_param('i', $id);
            }
            $stmt->execute();
            $this->memcache->delete("services");  // Invalidate cache
            $resp['status'] = 'success';
        }
        return json_encode($resp);
    }

    // Delete a service with Memcached invalidation
    public function delete_service() {
        extract($_POST);
        $stmt = $this->conn->prepare("DELETE FROM services WHERE id = ?");
        $stmt->bind_param('i', $id);
        $delete = $stmt->execute();
        if ($delete) {
            $this->memcache->delete("services");  // Invalidate cache
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'error';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    // Delete ticket
    public function delete_ticket() {
        extract($_POST);
        $stmt = $this->conn->prepare("DELETE FROM tickets WHERE id = ?");
        $stmt->bind_param('i', $id);
        $delete = $stmt->execute();
        if ($delete) {
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'error';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    // Save ticket
    public function save_ticket() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id'))) {
                if ($k == 'description') $v = addslashes($v);
                if (!empty($data)) $data .= " , ";
                $data .= " {$k} = '{$v}' ";
            }
        }
        $stmt = $this->conn->prepare("SELECT * FROM tickets WHERE ticket_number = ? AND id != ?");
        $stmt->bind_param('si', $ticket_number, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $resp['status'] = 'duplicate';
        } else {
            if (empty($id)) {
                $stmt = $this->conn->prepare("INSERT INTO tickets SET $data");
            } else {
                $stmt = $this->conn->prepare("UPDATE tickets SET $data WHERE id = ?");
                $stmt->bind_param('i', $id);
            }
            $stmt->execute();
            $resp['status'] = 'success';
        }
        return json_encode($resp);
    }

    // Save comment
    public function save_comment() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id'))) {
                if ($k == 'comment') $v = addslashes($v);
                if (!empty($data)) $data .= " , ";
                $data .= " {$k} = '{$v}' ";
            }
        }
        if (empty($id)) {
            $stmt = $this->conn->prepare("INSERT INTO ticket_comment SET $data");
        } else {
            $stmt = $this->conn->prepare("UPDATE ticket_comment SET $data WHERE id = ?");
            $stmt->bind_param('i', $id);
        }
        $stmt->execute();
        $resp['status'] = 'success';
        return json_encode($resp);
    }

    // Delete comment
    public function delete_comment() {
        extract($_POST);
        $stmt = $this->conn->prepare("DELETE FROM ticket_comment WHERE id = ?");
        $stmt->bind_param('i', $id);
        $delete = $stmt->execute();
        if ($delete) {
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'error';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    // Save quote
    public function save_quote() {
        extract($_POST);
        $data = "";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id'))) {
                if ($k == 'quote') $v = addslashes($v);
                if (!empty($data)) $data .= " , ";
                $data .= " {$k} = '{$v}' ";
            }
        }
        if (empty($id)) {
            $stmt = $this->conn->prepare("INSERT INTO ticket_quotes SET $data");
        } else {
            $stmt = $this->conn->prepare("UPDATE ticket_quotes SET $data WHERE id = ?");
            $stmt->bind_param('i', $id);
        }
        $stmt->execute();
        $resp['status'] = 'success';
        return json_encode($resp);
    }

    // Load quote
    public function load_quote() {
        extract($_POST);
        $stmt = $this->conn->prepare("SELECT * FROM ticket_quotes WHERE ticket_id = ?");
        $stmt->bind_param('i', $ticket_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $row['quote'] = strip_tags(stripslashes($row['quote']));
            $data[] = $row;
        }
        $resp['status'] = 'success';
        $resp['data'] = $data;
        return json_encode($resp);
    }

    // Delete quote
    public function delete_quote() {
        extract($_POST);
        $stmt = $this->conn->prepare("DELETE FROM ticket_quotes WHERE id = ?");
        $stmt->bind_param('i', $id);
        $delete = $stmt->execute();
        if ($delete) {
            $resp['status'] = 'success';
        } else {
            $resp['status'] = 'error';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

    // Update ticket status
    public function ticket_update_status() {
        extract($_POST);
        $stmt = $this->conn->prepare("UPDATE tickets SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $status, $id);
        $stmt->execute();
        $resp['status'] = 'success';
        return json_encode($resp);
    }
}


$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'load_service_category':
		echo $Master->load_service_category();
	break;
	case 'load_service':
		echo $Master->load_service();
	break;
	case 'load_tickets':
		echo $Master->load_tickets();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_service_category':
		echo $Master->delete_service_category();
	break;
	case 'save_service':
		echo $Master->save_service();
	break;
	case 'delete_service':
		echo $Master->delete_service();
	break;
	case 'save_ticket':
		echo $Master->save_ticket();
	break;
	case 'save_comment':
		echo $Master->save_comment();
	break;
	case 'load_comments':
		echo $Master->load_comments();
	break;
	case 'delete_comment':
		echo $Master->delete_comment();
	break;
	case 'delete_ticket':
		echo $Master->delete_ticket();
	break;
	case 'save_quote':
		echo $Master->save_quote();
	break;
	case 'load_quote':
		echo $Master->load_quote();
	break;
	case 'delete_quote':
		echo $Master->delete_quote();
	break;
	case 'ticket_update_status':
		echo $Master->ticket_update_status();
	break;
	default:
	// echo $sysset->index();
	break;
}