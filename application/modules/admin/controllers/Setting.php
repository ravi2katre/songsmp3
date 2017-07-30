<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // Frontend index CRUD
    public function index()
    {
        $crud = $this->generate_crud('settings');
        $crud->fields('setting_name', 'setting_value', 'setting_description', '	setting_type');
        $crud->columns('setting_name', 'setting_value', 'setting_description', '	setting_type');
        $this->unset_crud_fields('setting_id');
        // disable direct create / delete Frontend User
        $crud->unset_read();
        //$crud->unset_add();
        //$crud->unset_delete();
        $this->mPageTitle = 'Settings';
        $this->render_crud();
    }

    // Frontend pages CRUD
    public function order_statuses()
    {
        $crud = $this->generate_crud('order_statuses');
        //$crud->set_rules('refer_by_name','Refer By Name','required|unique');
        $crud->columns('order_status_value', 'order_description', 'order_status_sort');
        $crud->fields('order_status_value', 'order_description', 'order_status_sort');
        //$this->unset_crud_fields('order_status_id');
        // disable direct create / delete Frontend User
        $crud->unset_read();
        //$crud->unset_add();
        //$crud->unset_delete();
        // $crud->set_relation('parent_id','pages','title');
        $crud->display_as('order_status_value', 'Order Status');
        $crud->display_as('order_description', 'Description');
        $crud->display_as('order_status_sort', 'Sort');
        $this->mPageTitle = 'Order Statuses';
        $this->render_crud();
    }

    // Frontend pages CRUD
    public function emails()
    {
        $crud = $this->generate_crud('emails');
        $crud->set_rules('subject', 'Subject', 'required');
        $crud->set_rules('mail_to', 'Mail to', 'required');
        $crud->set_rules('mail_from', 'Mail from', 'required');
        $crud->set_rules('mail_from_name', 'Mail from name', 'required');
        $crud->set_rules('content', 'Contents', 'required');
        $crud->columns('title', 'subject');
        $this->unset_crud_fields('id');
        // disable direct create / delete Frontend User
        $crud->unset_read();
        //$crud->unset_add();
        //$crud->unset_delete();
        $this->mPageTitle = 'Emails';
        $this->render_crud();
    }

    public function testmail()
    {
        //mail goes here
        $this->load->model('Emails_model');
        $message_vars = array();
        /*$message_vars['feedback_comments'] = $comment;
       $message_vars['support_email'] = 'rkatre@tiuconsulting.com';
       $message_vars['customer_email'] = 'rkatre@tiuconsulting.com';
       $message_vars['customer_name'] = $this->mCustomer[0]->customer_name;
       $message_vars['rate'] = $this->input->post('rate');*/
        $email_record_id = 3;
        $this->Emails_model->send_email_from_db($email_record_id, $message_vars);
        echo "admin/setting/testmail/   <br>   Email Sent.";
        exit;
    }

    // Frontend referby CRUD
    public function referby()
    {
        $crud = $this->generate_crud('refer_by');
        //$crud->set_rules('refer_by_name','Refer By Name');
        $crud->display_as('refer_by_name', 'Referred by');
        $crud->fields('refer_by_name');
        $crud->columns('refer_by_name');
        $this->unset_crud_fields('refer_by_id');
        $crud->unset_read();
        $crud->unset_print();
        $crud->unset_export();
        //$crud->unset_add();
        //$crud->unset_delete();
        $crud->set_subject('Referred by');
        $crud->set_lang_string('form_add', 'Updating existing customer')
            ->set_lang_string('form_back_to_list', 'Go back to customers page')
            ->set_lang_string('form_save', 'Save customer into the database');
        $this->mPageTitle = 'Referred by';
        $this->render_crud();
    }

    public function packages()
    {
        $crud = $this->generate_crud('packages');
        //$crud->set_table('promoters');
        $crud->columns('package_name'
        );
        $crud->fields('package_name',
            'parent_package_id',
            'package_summary',
            'package_description',
            'package_type',
            'package_credit_amount');
        $crud->set_relation('parent_package_id', 'packages', 'package_name');
        $crud->unique_fields(array('package_name'));
        $crud->required_fields('package_name', '');
        $crud->display_as('discount_id', 'package_type', 'package_credit_amount');
        $crud->set_subject('Packages');
        //$output   = $crud->render();
        //$crud->callback_before_insert(array($this,'save_promoter'));
        //$crud->callback_before_update(array($this,'save_promoter'));
        $this->render_crud();
    }

    public function services($opr = NULL, $service_id = 0)
    {
        $crud = $this->generate_crud('services');
        //get_layout();
        if ($opr == 'edit' || $opr == 'add') {
            $this->load->model('Service_model');
            $services = $this->input->get_post('services');
            if ($services) {
                $services['service_has_quantity_help_text'] = htmlspecialchars($services['service_has_quantity_help_text']);
                $services['service_desc'] = htmlspecialchars($services['service_desc']);
                $services['service_short_desc'] = htmlspecialchars($services['service_short_desc']);
                if ($services['service_id'] <= 0) {
                    unset($services['service_id']);
                    $service_id = $this->Service_model->insert_service($services);
                } else {
                    //print_r($detail); exit;
                    $service_id = (int)$services['service_id'];
                    unset($services['service_id']);
                    $this->Service_model->update_service($services, $service_id);
                    $this->Service_model->delete_services_attributes($service_id);
                }
                $service_attributeIds = $this->input->get_post('attributes');
                foreach ($service_attributeIds as $key => $serviceattributeId) {
                    $data = array();
                    $data['service_id'] = $service_id;
                    $data['attribute_id'] = $serviceattributeId;
                    $all_attributs[] = $data;
                }
                if ($all_attributs) {
                    $this->Service_model->insert_services_attributes($all_attributs);
                }
                redirect('/admin/setting/services');
            }
            $this->mViewData['service'] = $this->Service_model->getServiceDetail($service_id);
            $attributes = $this->Service_model->get_all_attributes();
            foreach ($attributes as $key => $attribute) {
                $attributeValues = $this->Service_model->get_attribute_values($attribute['attribute_id']);
                $attributes[$key]['attribute_values'] = array();
                if ($attributeValues) {
                    foreach ($attributeValues as $inner_key => $attributeValue) {
                        $attributes[$key]['attribute_values'][] = $attributeValue;
                    }
                }
            }
            $this->mViewData['attributes'] = $attributes;
            $serviceAttributes = $this->Service_model->getServiceAttributes($service_id);
            $detail['attributes'] = array();
            foreach ($serviceAttributes as $key => $serviceAttribute) {
                $detail['attributes'][] = $serviceAttribute['attribute_id'];
            }
            $this->mViewData['detail'] = $detail;
            $this->mViewData['prev_attribute'] = $this->get_service($service_id, 'prev');
            $this->mViewData['next_attribute'] = $this->get_service($service_id, 'next');
            // $this->render();
            $this->render('services/service_detail');
            //exit;
        } else {
            //$crud->set_rules('refer_by_name','Refer By Name','required|unique');
            $crud->columns('service_name');
            $this->unset_crud_fields('product_category_id', 'pay_per_minute_rate_id', 'country_code');
            // disable direct create / delete Frontend User
            $crud->unset_read();
            $this->mPageTitle = 'All Services';
            $this->render_crud();
        }
    }

    public function get_service($service_id, $type)
    {
        if ($type == 'prev') {
            $sql = 'SELECT service_id FROM services WHERE service_id < ' . $service_id . ' ORDER BY service_id desc LIMIT 1';
            return $this->db->query($sql)->row()->service_id;
        }
        if ($type == 'next') {
            $sql = 'SELECT service_id FROM services WHERE service_id > ' . $service_id . ' ORDER BY service_id LIMIT 1';
            return $this->db->query($sql)->row()->service_id;
        }
    }

    public function attributes($opr = NULL, $attribute_id = 0, $service_id = 0)
    {
        error_reporting(0);
        $crud = $this->generate_crud('attributes');
        if ($opr == 'edit' || $opr == 'add') {
            $this->load->model('Service_model');
            //Sql to get the max sort id.
            $sqlMaxSortId = "SELECT MAX(attribute_sort) as maxSortId FROM attributes";
            $query = $this->db->query($sqlMaxSortId);
            $maxSortId = $query->row_array();
            $detail = $this->input->get_post('attributes');
            $dependence = $this->input->get_post('dependence');
            if ($detail) {
                $detail['hide_price'] = (isset($detail['hide_price'])) ? 1 : 0;
                $detail['attribute_desc'] = htmlspecialchars($detail['attribute_desc'], ENT_QUOTES);
                $attributeIdExist = $detail['attribute_id'];
                if (!$detail['attribute_id']) {
                    unset($detail['attribute_id']);
                    $detail['attribute_sort'] = $maxSortId['maxSortId'] + 1;
                    $insertdata = $detail;
                    unset($insertdata['attribute_values']);
                    unset($insertdata['attribute_customer_prices']);
                    unset($insertdata['attribute_free_text_field_size']);
                    unset($insertdata['dependence']);
                    $attribute_id = $this->Service_model->insert_attributes($insertdata);
                    if ($service_id > 0) {
                        $data = array();
                        $data['service_id'] = $service_id;
                        $data['attribute_id'] = $attribute_id;
                        $this->Service_model->insert_services_attributes(array($data));
                    }
                    $msg = 2;
                } else {
                    $attribute_id = (int)$detail['attribute_id'];
                    unset($detail['attribute_id']);
                    $array['attribute_name'] = $detail['attribute_name'];
                    $array['parent_attribute_id'] = $detail['parent_attribute_id'];
                    $array['attribute_desc'] = $detail['attribute_desc'];
                    $array['attribute_error'] = $detail['attribute_error'];
                    $array['attribute_one_time_fee_only'] = $detail['attribute_one_time_fee_only'];
                    $array['informational_service'] = $detail['informational_service'];
                    $array['hide_price'] = $detail['hide_price'];
                    $this->Service_model->update_attribute($array, $attribute_id);
                    $msg = 1;
                }
                if ($detail['attribute_type'] == ATTRIBUTE_TYPE_PREDEFINED_VALUES || $detail['attribute_type'] == ATTRIBUTE_TYPE_RADIO || $detail['attribute_type'] == ATTRIBUTE_TYPE_CHECKBOX) {
                    $attribute_values = $detail['attribute_values'];
                    $attribute_values = explode(',', $attribute_values);
                    $values = $this->Service_model->getAttributeValues($attribute_id);
                    $usedAttrValueId = array();
                    $i = 1;
                    foreach ($attribute_values as $key => $attribute_value) {
                        $data = array();
                        $data['attribute_id'] = $attribute_id;
                        $data['attribute_value'] = trim($attribute_value);
                        $data['attribute_value_sort'] = $i++;
                        $data['attribute_free_text_field_size'] = '';
                        if (isset($values[$key])) {
                            $usedAttrValueId [] = $values[$key]['value_id'];
                            $this->Service_model->update_attributes_values($data, $values[$key]['value_id']);
                        } else {
                            $this->Service_model->insert_attributes_values($data);
                        }
                    }
                    foreach ($values as $key => $row) {
                        if (!in_array($row['value_id'], $usedAttrValueId)) {
                            $this->Service_model->delete_attributes_values($row['value_id']);
                            $this->Service_model->delete_dependence($row['value_id']);
                        }
                    }
                } else if ($detail['attribute_type'] == ATTRIBUTE_TYPE_RATE_CHANGE) {
                    $attribute_values = $detail['attribute_values'];
                    $attribute_values = explode(',', $attribute_values);
                    $attribute_customer_prices = $detail['attribute_customer_prices'];
                    $attribute_customer_prices = explode(',', $attribute_customer_prices);
                    if (!isset($page['error'])) {
                        $values = $this->Service_model->get_attribute_values($attribute_id);
                        $usedAttrValueId = array();
                        $i = 1;
                        foreach ($attribute_values as $key => $attribute_value) {
                            $data = array();
                            $data['attribute_id'] = $attribute_id;
                            $data['attribute_value'] = trim($attribute_value);
                            $data['attribute_customer_price'] = trim($attribute_customer_prices[$key]);
                            $data['attribute_value_sort'] = $i++;
                            $data['attribute_free_text_field_size'] = '';
                            if (isset($values[$key])) {
                                $usedAttrValueId [] = $values[$key]['value_id'];
                                $this->Service_model->update_attributes_values($data, $values[$key]['value_id']);
                            } else {
                                $this->Service_model->insert_attributes_values($data);
                            }
                        }
                        foreach ($values as $key => $row) {
                            if (!in_array($row['value_id'], $usedAttrValueId)) {
                                $this->Service_model->delete_attributes_values($row['value_id']);
                                $this->Service_model->delete_dependence($row['value_id']);
                            }
                        }
                    }
                } else if (($detail['attribute_type'] == ATTRIBUTE_TYPE_FREE_TEXT)) //ATTRIBUTE_TYPE_FREE_TEXT
                {
                    $attribute_values = $detail['attribute_free_text_field_size'];
                    $free_text_value = $this->Service_model->getAttributeValues($attribute_id);
                    $data = array();
                    $data['attribute_id'] = $attribute_id;
                    $data['attribute_free_text_field_size'] = $attribute_values;
                    if (!empty($free_text_value)) {
                        $this->Service_model->update_attributes_values($data, $attribute_id);
                    } else {
                        if (!empty($detail['attribute_free_text_field_size'])) {
                            $this->Service_model->insert_attributes_values($data);
                        }
                    }
                    if (count($free_text_value) > 0 && empty($detail['attribute_free_text_field_size']) && !empty($attribute_id)) {
                        $values = $this->Service_model->getAttributeValues($attribute_id);
                        $this->Service_model->delete_attributes_values_by_attribute_id($attribute_id);
                        foreach ($values as $key => $row) {
                            $this->Service_model->delete_dependence($row['value_id']);
                        }
                    }
                }
                $detail['dependence'] = implode(",", $detail['dependence']);
                $this->db->where("dependent_attribute_id NOT IN('{$detail['dependence']}') AND attribute_id = $attribute_id");
                $this->db->delete("dependence");
                foreach ($dependence as $dependenceKey => $dependenceVal) {
                    $dependenceKey = str_replace('_', '#', $dependenceKey);
                    $field['display'] = $dependenceVal['display'];
                    if ($this->input->get_post('mandatory') == 'on' || $detail['informational_service'] == 1) {
                        $this->db->where("unique_id='" . $dependenceKey . "'");
                        $this->db->delete("dependence");
                    } else {
                        $dKeys = explode("#", $dependenceKey);
                        $field['unique_id'] = $dependenceKey;
                        $field['attribute_id'] = $dKeys[0];
                        $field['dependent_attribute_id'] = ($dKeys[2]) ? $dKeys[2] : 0;
                        $field['value_id'] = ($dKeys[1]) ? $dKeys[1] : 0;
                        $field['value'] = $dependenceVal['value'];
                        $this->db->select("*");
                        $this->db->from("dependence");
                        $this->db->where("unique_id='" . $dependenceKey . "'");
                        $list = $this->db->get()->row_array();
                        if (array_key_exists('value_id', $list)) {
                            $this->db->where("unique_id= '" . $dependenceKey . "'");
                            $this->db->update("dependence", $field);
                        } else {
                            $this->db->insert("dependence", $field);
                        }
                    }
                }
                //CODE MAKE THE ARRTIBUTE MANDITROY
                if ($this->input->get_post('mandatory') == 'on' && $attribute_id != "") {
                    $Updatedata['mandatory'] = 'Y';
                } else {
                    $Updatedata['mandatory'] = 'N';
                }
                $this->db->where("attribute_id = $attribute_id");
                $this->db->update("attributes", $Updatedata);
            }
            $services = $this->input->get_post('services');
            if ($services) {
                $services['service_has_quantity_help_text'] = htmlspecialchars($services['service_has_quantity_help_text']);
                $services['service_desc'] = htmlspecialchars($services['service_desc']);
                $services['service_short_desc'] = htmlspecialchars($services['service_short_desc']);
                if ($services['service_id'] <= 0) {
                    unset($services['service_id']);
                    $this->Service_model->insert_service($services);
                } else {
                    //print_r($detail); exit;
                    $service_id = (int)$services['service_id'];
                    unset($services['service_id']);
                    $this->Service_model->update_service($services, $service_id);
                    $this->Service_model->delete_services_attributes($service_id);
                }
                $service_attributeIds = $this->input->get_post('attributes');
                foreach ($service_attributeIds as $key => $serviceattributeId) {
                    $data = array();
                    $data['service_id'] = $service_id;
                    $data['attribute_id'] = $serviceattributeId;
                    $all_attributs[] = $data;
                }
                $this->Service_model->insert_services_attributes($all_attributs);
                redirect('/admin/setting/attributes');
            }
            if ($attribute_id > 0) {
                $detail = $this->Service_model->get_stored_attribute($attribute_id);
                $attributeValues = $this->Service_model->get_attribute_values($attribute_id);
                $detail['attribute_free_text_field_size'] = $attributeValues[0]['attribute_free_text_field_size'];
                $detail['attribute_values'] = array();
                $detail['attribute_customer_prices'] = array();
                foreach ($attributeValues as $key => $attributeValue) {
                    $detail['attribute_values'][] = $attributeValue['attribute_value'];
                    $detail['attribute_customer_prices'][] = $attributeValue['attribute_customer_price'];
                }
                $detail['attribute_values'] = implode($detail['attribute_values'], ', ');
                $detail['attribute_customer_prices'] = implode($detail['attribute_customer_prices'], ', ');
                $this->mPageTitle = 'Edit Attribute';
                $this->mViewData['detail'] = $detail;
                $sql = "SELECT GROUP_CONCAT(distinct dep.dependent_attribute_id ) as dependency_set_by_attribue FROM dependence dep WHERE dep.attribute_id = $attribute_id";
                $query = $this->db->query($sql);
                $dependence = $query->row_array();
                $this->mViewData['dependence'] = explode(",", $dependence['dependency_set_by_attribue']);
                $this->mViewData['prev_attribute'] = $this->get_attribute($detail['attribute_sort'], 'prev');
                $this->mViewData['next_attribute'] = $this->get_attribute($detail['attribute_sort'], 'next');
            } else {
                $this->mPageTitle = 'Add Attribute';
            }
            $this->mViewData['ATTRIBUTE_TYPE_RADIO'] = ATTRIBUTE_TYPE_RADIO;
            $this->mViewData['ATTRIBUTE_TYPE_CHECKBOX'] = ATTRIBUTE_TYPE_CHECKBOX;
            $attribute_types = array();
            $attribute_types[ATTRIBUTE_TYPE_PREDEFINED_VALUES] = 'Predefined Values';
            $attribute_types[ATTRIBUTE_TYPE_FREE_TEXT] = 'Free Text';
            $attribute_types[ATTRIBUTE_TYPE_RATE_CHANGE] = 'Rate Change';
            $attribute_types[ATTRIBUTE_TYPE_CUSTOM_CHANGE] = 'Custom Price';
            $attribute_types[ATTRIBUTE_TYPE_SINGLE_LINE_FREE_TEXT] = 'Single Line Free Text';
            $attribute_types[ATTRIBUTE_TYPE_RADIO] = 'Radio Type';
            $attribute_types[ATTRIBUTE_TYPE_CHECKBOX] = 'Checkbox Type';
            $this->mViewData['attribute_types'] = $attribute_types;
            $this->mViewData['attributes'] = $this->Service_model->get_all_attributes();
            $this->mViewData['service_id'] = $service_id;
            $this->render('services/attribute_detail');
            //exit;
        } else {
            //$crud->set_rules('refer_by_name','Refer By Name','required|unique');
            //$crud->output((object) array('output' => '', 'js_files' => array(), 'css_files' => array()));
            $this->mPageTitle = 'All Attributes';
            $crud->columns('attribute_name', 'value');
            $crud->display_as('attribute_name', 'Name');
            $crud->display_as('value', 'Value');
            $crud->order_by('attribute_sort ', 'asc');
            $crud->callback_column('value', array($this, '_callback_value'));
            $crud->callback_delete(array($this, 'delete_attribute'));
            $crud->unset_read();
            $this->grocery_crud->set_js('assets/grocery_crud/js/jquery-1.11.1.min.js');
            $this->grocery_crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.ui.datetime.js');
            $this->render_crud();
        }
    }

    public function get_attribute($attribute_sort, $type)
    {
        if ($type == 'prev') {
            $sql = 'SELECT attribute_id FROM attributes WHERE attribute_sort < ' . $attribute_sort . ' ORDER BY attribute_sort desc LIMIT 1';
            return $this->db->query($sql)->row()->attribute_id;
        }
        if ($type == 'next') {
            $sql = 'SELECT attribute_id FROM attributes WHERE attribute_sort > ' . $attribute_sort . ' ORDER BY attribute_sort LIMIT 1';
            return $this->db->query($sql)->row()->attribute_id;
        }
    }

    public function _callback_value($value, $row)
    {
        $this->load->model('Service_model');
        $attributeValues = $this->Service_model->get_attribute_values($row->attribute_id);
        //cidb($attributeValues);
        $options = '';
        if (count($attributeValues) > 0) {
            $option = '';
            foreach ($attributeValues as $attributeValue) { //cidb($attributeValue);
                if ($attributeValue["attribute_value"]) {
                    $option .= '<option>' . $attributeValue["attribute_value"] . '</option>';
                }
            }
            if ($option) {
                $options = '<select>';
                $options .= $option;
                $options .= '</select>';
            } else {
                $options = '<input type="text>"';
            }
        } else {
            $options = '<input type="text>"';
        }
        return $options;
    }

    public function delete_attribute($primary_key)
    {
        $this->db->delete('services_attributes', array('attribute_id' => $primary_key));
        $this->db->delete('attributes_values', array('attribute_id' => $primary_key));
        $this->db->delete('attributes', array('attribute_id' => $primary_key));
        return true;
        //return $this->db->update('cms_user',array('deleted' => '1'),array('id' => $primary_key));
    }

    public function sort_attributes()
    {
        error_reporting(0);
        $this->load->model('Service_model');
        $this->mViewData['list'] = $this->Service_model->get_all_attributes();
        $this->render('services/attribute_short');
    }

    public function attribute_sort()
    {
        $attribute_sort = $this->input->get_post('sorted_attribute_ids');
        if ($attribute_sort) {
            $sorted_attribute_ids = explode('_', $attribute_sort);
        }
        $this->load->model('Service_model');
        $sort_order = 1;
        foreach ($sorted_attribute_ids as $attribute_id) {
            $data = array();
            $data['attribute_sort'] = $sort_order;
            $this->Service_model->update_attribute($data, $attribute_id);
            $sort_order++;
        }
        return true;
    }

    function status_reason()
    {
        $crud = $this->generate_crud('hold_reasons');
        $crud->display_as('status_id', 'Status');
        $crud->display_as('hold_reason', 'Reason');
        $crud->columns('hold_reason', 'status_id');
        $crud->fields('status_id',
            'hold_reason',
            'parameter1',
            'parameter2',
            'parameter3',
            'parameter4',
            'parameter5',
            'send_email',
            'email_template');
        $crud->set_relation('status_id', 'order_statuses', 'order_status_value');
        //$crud->unique_fields(array('hold_reason_id'));
        $crud->required_fields('status_id', 'hold_reason');
        $crud->unset_print();
        $crud->unset_read();
        $this->mPageTitle = 'Status Reasons';
        $this->render_crud();
    }

    public function email_notifications()
    {
        $crud = $this->generate_crud('emailnotifications');
        $crud->fields('enot_id', 'order_id', 'sub_order_id', 'order_status_id', 'en_date');
        $crud->columns('enot_id', 'order_id', 'sub_order_id', 'order_status_id', 'en_date');
        $crud->set_relation('order_status_id', 'order_statuses', 'order_status_value');
        //$this->unset_crud_fields('en_id');
        $crud->unset_read();
        $this->mPageTitle = 'emailnotifications';
        $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_edit();
        $this->render_crud();
    }

    public function frontend_navigation()
    {
        $crud = $this->generate_crud('nav_pages_front');
        $crud->fields('name', 'url', 'parent_id', 'meta_keywords', 'meta_descriptions', 'meta_title', 'sort', 'disabled');
        $crud->columns('name', 'url', 'parent_id', 'meta_keywords', 'meta_descriptions', 'meta_title', 'sort', 'disabled');
        $crud->unset_texteditor('meta_keywords', 'full_text');
        $crud->unset_texteditor('meta_descriptions', 'full_text');
        $crud->set_relation('parent_id', 'nav_pages_front', 'name');
        $this->unset_crud_fields('querystring');
        $this->unset_crud_fields('id');
        $crud->unset_read();
        $this->mPageTitle = 'Frontend Navigation';
        //$crud->unset_add();
        // $crud->unset_delete();
        //$crud->unset_edit();
        $this->render_crud();
    }

    public function quote_rejection_reasons()
    {
        $crud = $this->generate_crud('quote_rejection_reasons');
        $crud->set_rules('quote_rejection_reason_name', 'Quote Rejection Reason', 'required');
        $crud->fields('quote_rejection_reason_name');
        $crud->columns('quote_rejection_reason_name');
        $this->unset_crud_fields('quote_rejection_reason_id');
        // disable direct create / delete Frontend User
        $crud->unset_read();
        //$crud->unset_add();
        //$crud->unset_delete();
        $this->mPageTitle = 'Quote Rejection Reasons';
        $this->render_crud();
    }

    public function refund_reason()
    {
        $crud = $this->generate_crud('refund_reasons');
        $crud->set_rules('refund_reason_name', 'Refund Reason', 'required');
        $crud->fields('refund_reason_name');
        $crud->columns('refund_reason_name');
        $this->unset_crud_fields('refund_id');
        // disable direct create / delete Frontend User
        $crud->unset_read();
        //$crud->unset_add();
        //$crud->unset_delete();
        $this->mPageTitle = 'Refund Reasons';
        $this->render_crud();
    }

    public function file()
    {
        $crud = $this->generate_crud('file');
        //$crud->set_rules('refund_reason_name','Refund Reason','required');
        //$crud->fields('refund_reason_name');
        //$crud->columns('refund_reason_name');
        //$this->unset_crud_fields('refund_id');
        // disable direct create / delete Frontend User
        //$crud->unset_read();
        //$crud->unset_add();
        //$crud->unset_delete();
        $this->mPageTitle = 'File';
        $this->render_crud();
    }

    public function category()
    {
        $crud = $this->generate_crud('category');
        //$crud->set_rules('refund_reason_name','Refund Reason','required');
        $crud->fields('name', 'thumb');
        $crud->columns('name', 'thumb');
        //$this->unset_crud_fields('refund_id');
        // disable direct create / delete Frontend User
        //$crud->unset_read();
        //$crud->unset_add();
        //$crud->unset_delete();
        $crud->set_field_upload('thumb', 'uploads/cat_images');

        $this->mPageTitle = 'Category';
        $this->render_crud();
    }
}