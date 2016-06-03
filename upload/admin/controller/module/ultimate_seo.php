<?php
class ControllerModuleUltimateSeo extends Controller {
	private $error = array();
        
        
	public function index() {
                $data = array();
                $data = array_merge($data, $this->load->language('module/ultimate_seo'));
                
		$this->document->setTitle($this->language->get('heading_title'));
                
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('useo', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('useo_success_text');
			
                        $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
             
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else if (isset($this->session->data['error']) ) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}
		else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
		);

		$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_module'),
		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);
	
		$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('useo_heading_title'),
		'href'      => $this->url->link('module/ultimate_seo', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);

		$data['button_save'] = $this->language->get('useo_save');
		$data['button_cancel'] = $this->language->get('useo_cancel');

		if (isset($this->request->post['useo_meta_num'])) {
			$data['useo_meta_num'] = $this->request->post['useo_meta_num'];
		} else {
			$data['useo_meta_num'] = $this->config->get('useo_meta_num');
		}

		if (isset($this->request->post['useo_auto_meta'])) {
			$data['useo_auto_meta'] = $this->request->post['useo_auto_meta'];
		} else {
			$data['useo_auto_meta'] = $this->config->get('useo_auto_meta');
		}
		if ($data['useo_auto_meta'] == 'yes') $data['useo_auto_meta'] = 'checked';
		else $data['useo_auto_meta'] = '';

		$data['action'] = $this->url->link('module/ultimate_seo', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['heading_title'] = $this->language->get('useo_heading_title');
		$data['entry_meta_num'] = $this->language->get('useo_entry_meta_num');
		$data['entry_meta_num_description'] = $this->language->get('useo_entry_meta_num_description');
		$data['entry_auto_meta'] = $this->language->get('useo_entry_auto_meta');
		$data['entry_auto_meta_description'] = $this->language->get('useo_entry_auto_meta_description');

		$data['codeinspires_url'] = $this->url->link('module/ultimate_seo/support_page', 'token=' . $this->session->data['token'], 'SSL');
		$data['codeinspires'] = $this->config->get('codeinspires');

		$data['modules'] = array();
		
		if (isset($this->request->post['useo_module'])) {
			$data['modules'] = $this->request->post['useo_module'];
		} elseif ($this->config->get('useo_module')) { 
			$data['modules'] = $this->config->get('useo_module');
		}

		$this->load->model('design/layout');
                $this->load->model('design/banner');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
		$data['banners'] = $this->model_design_banner->getBanners();
                $data['token'] = $this->session->data['token'];
                $data['header'] = $this->load->controller('common/header');
                $data['column_left'] = $this->load->controller('common/column_left');
                $data['footer'] = $this->load->controller('common/footer');

$this->response->setOutput($this->load->view('module/ultimate_seo.tpl', $data));

	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ultimate_seo')) {
			$this->error['warning'] = 'You dont have permission to modify ultimate seo module.';
		}
		
		if (isset($this->request->post['useo_module'])) {
			foreach ($this->request->post['useo_module'] as $key => $value) {				
				
			}
		}	
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function support_page () {
		$this->load->language('module/ultimate_seo');
		if (!$this->user->hasPermission('modify', 'module/ultimate_seo')) {
			$this->session->data['error'] = 'You dont have permission to modify ultimate seo module';
		}
		else {
			$codeinspires = $this->config->get('codeinspires');
			if (isset($codeinspires) && $codeinspires == 1) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value`='0' WHERE `key`='codeinspires'");
			}
			else if (isset($codeinspires) && $codeinspires == 0) {
				$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value`='1' WHERE `key`='codeinspires'");
			}
		}
		$this->redirect($this->url->link('module/ultimate_seo', 'token=' . $this->session->data['token'], 'SSL'));
	}	

	public function install() {
		$this->db->query("DELETE FROM ". DB_PREFIX . "setting WHERE `key`='codeinspires'");
		$this->db->query("INSERT INTO ". DB_PREFIX . "setting VALUES (NULL,'". (int)$this->config->get('store_admin') ."','codeinspires','codeinspires','1','0')");
		$this->db->query("ALTER TABLE ". DB_PREFIX ."category_description ADD `u_title` VARCHAR( 255 ) NOT NULL ,ADD `u_h1` VARCHAR( 255 ) NOT NULL ,ADD `u_h2` VARCHAR( 255 ) NOT NULL ");
		$this->db->query("ALTER TABLE ". DB_PREFIX ."product_description ADD `u_title` VARCHAR( 255 ) NOT NULL ,ADD `u_h1` VARCHAR( 255 ) NOT NULL ,ADD `u_h2` VARCHAR( 255 ) NOT NULL ");
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX ."category_description WHERE meta_description = ''" );
		foreach($query->rows as $row) {
			if (empty($row['meta_description'])) {
			$meta_description = substr(strip_tags(html_entity_decode($row['description'])),0,180);
			$meta_description = trim(preg_replace('/[ ]{2,}|[\t]/', ' ', $meta_description));
			}
			else {
				$meta_description = $row['meta_description'];
			}
			$this->db->query("UPDATE ". DB_PREFIX ."category_description SET meta_description = '". $this->db->escape($meta_description) ."' WHERE category_id = '". (int)$row['category_id'] ."'");
		}
		$query = $this->db->query('SELECT * FROM ' . DB_PREFIX ."product_description WHERE meta_description = ''" );
		foreach($query->rows as $row) {
			if (empty($row['meta_description'])) {
			$meta_description = substr(strip_tags(html_entity_decode($row['description'])),0,180);
			$meta_description = trim(preg_replace('/[ ]{2,}|[\t]/', ' ', $meta_description));
			}
			else {
				$meta_description = $row['meta_description'];
			}
			$this->db->query("UPDATE ". DB_PREFIX ."product_description SET meta_description = '". $this->db->escape($meta_description) ."' WHERE product_id = '". (int)$row['product_id'] ."'");
		}
	}

	public function uninstall() {
		$this->db->query("ALTER TABLE " . DB_PREFIX . "category_description DROP `u_title`, DROP `u_h1`, DROP `u_h2`");
		$this->db->query("ALTER TABLE " . DB_PREFIX . "product_description DROP `u_title`, DROP `u_h1`, DROP `u_h2`");
	}

}

