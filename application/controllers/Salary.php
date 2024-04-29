<?php

class Salary extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Login_Process');

        $this->load->model('Salary_Process');

        $this->load->model('Admin_Process');
    }

    public function earning()
    {                     //Dashboard
        $sal_dtls = $this->Salary_Process->calculate_final_gross();
        $i = 0;
        $earning['sal_dtls'] = $sal_dtls;

        $this->load->view('post_login/payroll_main');
        $this->load->view("earning/dashboard", $earning);
        $this->load->view('post_login/footer');
    }

    public function earning_add()
    {                 //Add
        $catg_id = $this->input->get('catg_id');
        $sal_dt = $this->input->get('sys_dt');
        $sal_flag = $this->input->get('flag');
        $selected = array(
            'catg_id' => $catg_id > 0 ? $catg_id : '',
            'sal_date' => $sal_dt ? $sal_dt : date('Y-m-d'),
            'sal_flag' => $sal_flag ? $sal_flag : 0
        );

        $sal_list = array();
        $select = 'id, category';
        $catg_list = $this->Admin_Process->f_get_particulars("md_category", $select, NULL, 0);

        if (isset($_REQUEST['submit'])) {
            if ($catg_id > 0) {
                $sal_dt = $this->Salary_Process->earningDtls($catg_id, $sal_dt);
                $i = 0;
                foreach ($sal_dt as $dt) {
                    $sal_list[$i] = array(
                        'emp_name' => $dt->emp_name,
                        'emp_code' => $dt->emp_code,
                        'basic' => $dt->basic,
                        'ca' => $dt->ca,
                        'da' => $dt->da,
                        'ma' => $dt->ma,
                        'ip' => $dt->ip,
                        'fa' => $dt->fa,
                        'hra' => $dt->hra,
                        'dep' => $dt->dep,
                        'oa' => $dt->oa,
                        'bonus' => $dt->bonus,
                        'exp' => $dt->exp,
                        'ada' => $dt->ada,
                        'gross' => $dt->gross,
                        'lwp' => $dt->lwp,
                        'final_gross' => $dt->final_gross
                    );
                    $i++;
                }
            } else {
                $where = array('id' => $this->input->post('catg_id'));
                $sal_cal = $this->Admin_Process->f_get_particulars("md_category", null, $where, 1);
                $emp_list = $this->Salary_Process->get_emp_dtls($this->input->post('catg_id'));
                $i = 0;
                foreach ($emp_list as $emp) {
                    // $sa = round(($emp->basic_pay * $sal_cal->sa) / 100);
                    // $da = round((($emp->basic_pay) * $sal_cal->da) / 100);
                    $sal_breakup = $emp->basic_pay - $sal_cal->basic_max;
                    $da = $sal_breakup > 0 ? ((($sal_cal->basic_max * $sal_cal->da1)/100) + (($sal_breakup * $sal_cal->da2)/100)) : (($emp->basic_pay * $sal_cal->da1) / 100);
                    $da = round($da);
                    // $pf = (round($emp->basic_pay + $da) * $sal_cal->pf)/100;
                    $hra = round((($emp->basic_pay) * $sal_cal->hra) / 100);
                    $ma = round($sal_cal->ma);

                    $gross = $emp->basic_pay + $da + $hra + $ma;
                    $sal_list[$i] = array(
                        'emp_name' => $emp->emp_name,
                        'emp_code' => $emp->emp_code,
                        'basic' => $emp->basic_pay,
                        'ca' => 0.00,
                        'da' => $da,
                        'ma' => $ma,
                        'ip' => 0.00,
                        'fa' => 0.00,
                        'hra' => $hra,
                        'dep' => 0.00,
                        'oa' => 0.00,
                        'bonus' => 0.00,
                        'exp' => 0.00,
                        'ada' => 0.00,
                        'gross' => $gross,
                        'lwp' => 0,
                        'final_gross' => $gross
                    );
                    $i++;
                }
                $selected = array(
                    'catg_id' => $this->input->post('catg_id'),
                    'sal_date' => $this->input->post('sal_date'),
                    'sal_flag' => $sal_flag ? $sal_flag : 0
                );
            }
        }
        $data = array(
            'selected' => $selected,
            'catg_list' => $catg_list,
            'sal_list' => $sal_list
        );
        $this->load->view('post_login/payroll_main');
        $this->load->view("earning/add", $data);
        $this->load->view('post_login/footer');
    }

    function chk_sal()
    {
        $date = $this->input->get('sal_date');
        $catg_id = $this->input->get('catg_id');
        $table_name = 'td_income';
        $select = 'emp_code, effective_date, catg_id';
        $where = array(
            'MONTH(effective_date)' => date('m', strtotime($date)),
            'YEAR(effective_date)' => date('Y', strtotime($date)),
            'catg_id' => $catg_id
        );
        $res_dt = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
        if (count($res_dt) > 0) {
            echo true;
        } else {
            echo false;
        }
        // var_dump($res_dt);
    }

    function earning_save()
    {
        $data = $this->input->post();
        if ($data['flag'] == 0) {
            $table_name = 'td_income';
            $select = 'emp_code, effective_date, catg_id';
            $where = array(
                'MONTH(effective_date)' => date('m', strtotime($data['sal_date'])),
                'YEAR(effective_date)' => date('Y', strtotime($data['sal_date'])),
                'catg_id' => $data['catg_id']
            );
            $res_dt = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
            if (count($res_dt) > 0) {
                $this->session->set_flashdata('msg', 'Earning is already exist for this month');
                redirect('slrydtl');
            } else {
                if ($this->Salary_Process->earning_save($data)) {
                    $this->session->set_flashdata('msg', 'Successfully Inserted!');
                    redirect('slrydtl');
                } else {
                    $this->session->set_flashdata('msg', 'Data Not Inserted!');
                    redirect('slryad');
                }
            }
        } else {
            if ($this->Salary_Process->earning_save($data)) {
                $this->session->set_flashdata('msg', 'Successfully Inserted!');
                redirect('slrydtl');
            } else {
                $this->session->set_flashdata('msg', 'Data Not Inserted!');
                redirect('slryad');
            }
        }
    }

    public function f_sal_dtls()
    {                      //Salary earning amounts

        $emp_code = $this->input->get('emp_code');

        $data     = $this->Salary_Process->f_sal_dtls($emp_code);

        echo json_encode($data);
    }

    public function f_emp_dtls()
    {                   //Employee Details 

        $emp_code = $this->input->get('emp_code');

        $select   = array(
            "a.emp_code", "a.emp_name", "a.emp_catg", "b.district_name", "c.category_type"
        );

        $where    = array(
            "a.emp_dist = b.district_code" => NULL,
            "a.emp_catg = c.category_code" => NULL,
            "a.emp_code" => $emp_code
        );

        $data = $this->Salary_Process->f_get_particulars("md_employee a,md_district b,md_category c", $select, $where, 1);

        echo json_encode($data);
    }

    public function earning_edit()
    {                                         //Edit

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $sal_date   =   $this->input->post('sal_date');

            $emp_cd     =   $this->input->post('emp_code');

            $da         =   $this->input->post('da');

            $hra        =   $this->input->post('hra');

            $ma         =   $this->input->post('ma');

            $oa         =   $this->input->post('oa');

            $data_array = array(

                "da_amt"         =>  $da,

                "hra_amt"        =>  $hra,

                "med_allow"      =>  $ma,

                "othr_allow"     =>  $oa,

                "modified_by"    => $this->session->userdata['loggedin']['user_id'],

                "modified_dt"    =>  date('Y-m-d h:i:s')

            );

            $where = array(

                "emp_code"           =>  $emp_cd,

                "effective_date"     =>  $sal_date

            );

            $this->session->set_flashdata('msg', 'Successfully Updated!');

            $this->Salary_Process->f_edit('td_income', $data_array, $where);

            redirect('slrydtl');
        } else {

            $select = array(
                "a.*", "b.*", "c.*", "d.*"
            );

            $where = array(
                "a.emp_code = b.emp_code"           =>  NULL,

                "a.emp_catg = c.category_code"      => NULL,

                "a.emp_dist = d.district_code"      => NULL,

                "b.effective_date"                  =>  $this->input->get('date'),

                "a.emp_code"                        =>  $this->input->get('emp_code')

            );

            $earning['earning_dtls']  = $this->Salary_Process->f_get_particulars("md_employee a,td_income b,md_category c,md_district d", NULL, $where, 1);

            $this->load->view('post_login/payroll_main');
            $this->load->view("earning/edit", $earning);
            $this->load->view('post_login/footer');
        }
    }

    public function earning_delete()
    {                      //Delete income

        $where = array(

            "emp_code"          =>  $this->input->get('emp_code'),

            "effective_date"    =>  $this->input->get('effective_date')

        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');

        $this->Salary_Process->f_delete('td_income', $where);

        redirect("slrydtl");
    }

    public function deduction()
    {                       //Deduction Dashboard

        $data['deduction_list'] = $this->Salary_Process->calculate_final_deduction();
        $this->load->view('post_login/payroll_main');
        $this->load->view("deduction/dashboard", $data);
        $this->load->view('post_login/footer');
    }

    public function deduction_add()
    {                       //Add Dedcutions
        $catg_id = $this->input->get('catg_id');
        $sal_dt = $this->input->get('sys_dt');
        $sal_flag = $this->input->get('flag');
        $selected = array(
            'catg_id' => $catg_id > 0 ? $catg_id : '',
            'sal_date' => $sal_dt ? $sal_dt : date('Y-m-d'),
            'sal_flag' => $sal_flag ? $sal_flag : 0
        );

        $sal_list = array();
        $select = 'id, category';
        $catg_list = $this->Admin_Process->f_get_particulars("md_category", $select, NULL, 0);

        if (isset($_REQUEST['submit'])) {
            if ($catg_id > 0) {
                $sal_dt = $this->Salary_Process->deductionDtls($catg_id, $sal_dt);
                $i = 0;
                foreach ($sal_dt as $dt) {
                    $sal_list[$i] = array(
                        'emp_name' => $dt->emp_name,
                        'emp_code' => $dt->emp_code,
                        'gross' => $dt->gross,
                        'tds' => $dt->tds,
                        'pf' => $dt->pf,
                        'giss' => $dt->giss,
                        'sss' => $dt->sss,
                        'fes_adv' => $dt->fes_adv,
                        'gsli' => $dt->gsli,
                        'hr' => $dt->hr,
                        'od' => $dt->od,
                        'dms_loan_prn' => $dt->dms_loan_prn,
                        'dms_loan_intt' => $dt->dms_loan_intt,
                        'hrep_1_loan_pr' => $dt->hrep_1_loan_pr,
                        'hrep_1_loan_intt' => $dt->hrep_1_loan_intt,
                        'hrep_2_loan_pr' => $dt->hrep_2_loan_pr,
                        'hrep_2_loan_intt' => $dt->hrep_2_loan_intt,
                        'p_tax' => $dt->p_tax,
                        'assn' => $dt->assn,
                        'ex_adj' => $dt->ex_adj,
                        'mr_loan_1_prn' => $dt->mr_loan_1_prn,
                        'mr_loan_1_intt' => $dt->mr_loan_1_intt,
                        'mr_loan_2_prn' => $dt->mr_loan_2_prn,
                        'mr_loan_2_intt' => $dt->mr_loan_2_intt,
                        'med_loan_prn' => $dt->med_loan_prn,
                        'med_loan_intt' => $dt->med_loan_intt,
                        'spl_med_loan_prn' => $dt->spl_med_loan_prn,
                        'spl_med_loan_intt' => $dt->spl_med_loan_intt,
                        'tot_diduction' => $dt->tot_diduction,
                        'net_sal' => $dt->net_sal
                    );
                    $i++;
                }
            } else {
                $where = array('id' => $this->input->post('catg_id'));
                $sal_cal = $this->Admin_Process->f_get_particulars("md_category", null, $where, 1);
                $emp_list = $this->Salary_Process->get_emp_dtls($this->input->post('catg_id'));
                // echo '<pre>';
                // var_dump($emp_list);
                // exit;
                $i = 0;
                foreach ($emp_list as $emp) {
                    $sal = $this->Salary_Process->get_last_gross($emp->emp_code);
                    $pf = $this->Salary_Process->get_ptx($sal->final_gross);
                    $pf_cal = round((($sal->basic + $sal->da) * $sal_cal->pf)/100);
					// $cpf = $sal ? round((($sal->basic+$sal->sp+$sal->da) * $sal_cal->pf) / 100) : 'Fill Income First';

                    $sal_list[$i] = array(
                        'emp_name' => $emp->emp_name,
                        'emp_code' => $emp->emp_code,
                        'gross' => $sal ? $sal->final_gross : 'Fill Income First',
                        'tds' => 0,
                        'pf' => $pf_cal,
                        'giss' => 0.00,
                        'sss' => 0.00,
                        'fes_adv' => 0.00,
                        'gsli' => 0.00,
                        'hr' => 0.00,
                        'od' => 0.00,
                        'dms_loan_prn' => 0.00,
                        'dms_loan_intt' => 0.00,
                        'hrep_1_loan_pr' => 0.00,
                        'hrep_1_loan_intt' => 0.00,
                        'hrep_2_loan_pr' => 0.00,
                        'hrep_2_loan_intt' => 0.00,
                        'p_tax' => $pf->ptax,
                        'assn' => 0.00,
                        'ex_adj' => 0.00,
                        'mr_loan_1_prn' => 0.00,
                        'mr_loan_1_intt' => 0.00,
                        'mr_loan_2_prn' => 0.00,
                        'mr_loan_2_intt' => 0.00,
                        'med_loan_prn' => 0.00,
                        'med_loan_intt' => 0.00,
                        'spl_med_loan_prn' => 0.00,
                        'spl_med_loan_intt' => 0.00,
                        'tot_diduction' => $sal ? ($pf->ptax + $pf_cal) : 'Fill Income First',
                        'net_sal' => $sal ? $sal->final_gross - ($pf->ptax + $pf_cal) : 'Fill Income First'
                    );
                    $i++;
                }
                $selected = array(
                    'catg_id' => $this->input->post('catg_id'),
                    'sal_date' => $this->input->post('sal_date'),
                    'sal_flag' => $sal_flag ? $sal_flag : 0
                );
            }
        }
        $data = array(
            'selected' => $selected,
            'catg_list' => $catg_list,
            'sal_list' => $sal_list
        );
        $this->load->view('post_login/payroll_main');
        $this->load->view("deduction/add", $data);
        $this->load->view('post_login/footer');
    }

    function chk_deduction()
    {
        $date = $this->input->get('sal_date');
        $catg_id = $this->input->get('catg_id');
        $table_name = 'td_deductions';
        $select = 'emp_code, effective_date, catg_id';
        $where = array(
            'MONTH(effective_date)' => date('m', strtotime($date)),
            'YEAR(effective_date)' => date('Y', strtotime($date)),
            'catg_id' => $catg_id
        );
        $res_dt = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
        if (count($res_dt) > 0) {
            echo true;
        } else {
            echo false;
        }
        // var_dump($res_dt);
    }

    function deduction_save()
    {
        $data = $this->input->post();
        if ($data['flag'] == 0) {
            $table_name = 'td_deductions';
            $select = 'emp_code, effective_date, catg_id';
            $where = array(
                'MONTH(effective_date)' => date('m', strtotime($data['sal_date'])),
                'YEAR(effective_date)' => date('Y', strtotime($data['sal_date'])),
                'catg_id' => $data['catg_id']
            );
            $res_dt = $this->Admin_Process->f_get_particulars($table_name, $select, $where, 0);
            if (count($res_dt) > 0) {
                $this->session->set_flashdata('msg', 'Deduction is already exist for this month');
                redirect('slryded');
            } else {
                if ($this->Salary_Process->deduction_save($data)) {
                    $this->session->set_flashdata('msg', 'Successfully Inserted!');
                    redirect('slryded');
                } else {
                    $this->session->set_flashdata('msg', 'Data Not Inserted!');
                    redirect('slrydedad');
                }
            }
        } else {
            if ($this->Salary_Process->deduction_save($data)) {
                $this->session->set_flashdata('msg', 'Successfully Inserted!');
                redirect('slryded');
            } else {
                $this->session->set_flashdata('msg', 'Data Not Inserted!');
                redirect('slrydedad');
            }
        }
    }

    public function deduction_edit()
    {                                     //Edit Deductions

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $emp_cd     =   $this->input->post('emp_code');

            $data_array = array(

                // "ded_yr"           =>  $this->input->post('year'),

                // "ded_month"        =>  $this->input->post('month'),

                "insuarance"       =>  $this->input->post('sal_ins'),

                "ccs"              =>  $this->input->post('ccs'),

                "hbl"              =>  $this->input->post('hbl'),

                "telephone"        =>  $this->input->post('phone'),

                "med_adv"          =>  $this->input->post('med_adv'),

                "festival_adv"     =>  $this->input->post('fest_adv'),

                "tf"               =>  $this->input->post('tf'),

                "med_ins"          =>  $this->input->post('med_ins'),

                "comp_loan"        =>  $this->input->post('comp_loan'),

                "itax"             =>  $this->input->post('itax'),

                "gpf"              =>  $this->input->post('gpf'),

                "epf"              =>  $this->input->post('epf'),

                "other_deduction"  =>  $this->input->post('other_ded'),

                "ptax"             =>  $this->input->post('ptax'),

                "modified_by"      =>  $this->session->userdata['loggedin']['user_id'],

                "modified_dt"      =>  date('Y-m-d h:i:s')

            );


            $where = array(

                "emp_cd"       =>  $emp_cd

            );

            $this->session->set_flashdata('msg', 'Successfully Updated!');

            $this->Salary_Process->f_edit('td_deductions', $data_array, $where);

            redirect('slryded');
        } else {

            $emp_cd     =   $this->input->get('emp_cd');

            $select = array(

                "a.*", "b.*", "c.*", "d.*"

            );

            $where = array(

                "a.emp_code = b.emp_cd"         => NULL,

                "a.emp_dist = c.district_code"  => NULL,

                "a.emp_catg = d.category_code"  => NULL,

                "b.emp_cd"                      =>  $emp_cd

            );

            $deduction['month_list']        =   $this->Salary_Process->f_get_particulars("md_month", NULL, NULL, 0);

            $deduction['deduction_dtls']    =   $this->Salary_Process->f_get_particulars("md_employee a,td_deductions b,md_district c,md_category d", NULL, $where, 1);

            $this->load->view('post_login/payroll_main');

            $this->load->view("deduction/edit", $deduction);

            $this->load->view('post_login/footer');
        }
    }

    public function deduction_delete()
    {                   //Delete

        $where = array(

            "emp_cd"    =>  $this->input->get('empcd')

        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');

        $this->Salary_Process->f_delete('td_deductions', $where);

        redirect("slryded");
    }


    public function generation_delete()
    {      //unapprove salary slip delete       

        $where = array(
            "trans_date"  =>  $this->input->get('date'),
            "trans_no"    =>  $this->input->get('trans_no'),
            "sal_month"   => $this->input->get('month'),
            "sal_year"    =>  $this->input->get('year'),
            "catg_cd" => $this->input->get('catg_id'),
            "approval_status" => 'U'
        );

        $where1 = array(
            "trans_date"  =>  $this->input->get('date'),
            "trans_no"    =>  $this->input->get('trans_no'),
            "sal_month"   => $this->input->get('month'),
            "sal_year"    =>  $this->input->get('year'),
            "catg_id" => $this->input->get('catg_id'),
            "approval_status" => 'U'
        );

        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->Salary_Process->f_delete('td_salary', $where);
        $this->Salary_Process->f_delete('td_pay_slip', $where1);
        // echo $this->db->last_query();
        // die();
        redirect('genspl');
    }



    public function generate_slip()
    {                                //Payslip Generation

        //Generation Details
        // $generation['generation_dtls']  =   $this->Salary_Process->f_get_particulars("td_salary", NULL, array("approval_status" => 'U'), 0);
        $generation['generation_dtls']  =   $this->Salary_Process->generate_slip($trans_dt = null, $month = null, $year = null, $catg_id = null, $trans_no = null, 0);
        // echo $this->db->last_query();
        // exit;

        //Category List
        // $generation['category']         =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);

        $this->load->view('post_login/payroll_main');
        $this->load->view("generation/dashboard", $generation);
        $this->load->view('post_login/footer');
    }
    function generation_view()
    {
        $trans_dt = $this->input->get('trans_dt');
        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $catg_id = $this->input->get('catg_id');
        $trans_no = $this->input->get('trans_no');
        $generation['sal_dtls']  =   $this->Salary_Process->generate_slip($trans_dt, $month, $year, $catg_id, $trans_no, 1);
        //Category List
        $generation['category']   =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);
        // echo $this->db->last_query();
        // var_dump($generation['sal_dtls']);
        // exit;

        $this->load->view('post_login/payroll_main');
        $this->load->view("generation/edit_view", $generation);
        $this->load->view('post_login/footer');
    }
    public function get_required_yearmonth()
    {

        $category = $this->input->post('category');
        $max_year =   $this->Salary_Process->f_get_particulars("td_salary", NULL, array("approval_status" => 'A', 'catg_cd' => $category, '1 ORDER BY sal_year DESC, sal_month DESC limit 1' => NULL), 1);
        // echo '<pre>';
        // echo $this->db->last_query();
        // var_dump($max_year);
        // exit;
        if ($max_year) {
            if ($max_year->sal_month == 12) {
                $data['year'] = ($max_year->sal_year) + 1;
                $data['month'] = 1;
                $data['monthn'] = 'January';
            } else {
                $data['year'] = $max_year->sal_year ? $max_year->sal_year : date('Y');
                $data['month'] = $max_year->sal_month ? ($max_year->sal_month) + 1 : date('m');
                $data['monthn'] = $this->Salary_Process->f_get_particulars("md_month", NULL, array('id' => $data['month']), 1)->month_name;
            }
        } else {
            $data['year'] = $max_year ? $max_year->sal_year : date('Y');
            $data['month'] = $max_year ? ($max_year->sal_month) + 1 : date('m');
            $data['monthn'] = $this->Salary_Process->f_get_particulars("md_month", NULL, array('id' => $data['month']), 1)->month_name;
        }

        echo  json_encode($data);
    }

    public function generation_add()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $trans_dt     =   $this->input->post('sal_date');
            $sal_month    =   $this->input->post('month');
            $year         =   $this->input->post('year');
            $category     =   $this->input->post('category');
            //Check given category exsit or not
            //for given month and date
            $select     =   array("catg_cd");
            $where      =   array(
                "catg_cd"       =>  $category,
                "sal_month"     =>  $sal_month,
                "sal_year"      =>  $year
            );
            $flag     =   $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 1);
            if ($flag) {
                $this->session->set_flashdata('msg', 'For this month and category Payslip already generated!');
            } else {
                //Retrive max trans no
                $select     =   array("MAX(trans_no) trans_no");
                $where      =   array(
                    "trans_date"    =>  $trans_dt,
                    "sal_month"     =>  $sal_month,
                    "sal_year"      =>  $year
                );

                $trans_no     =   $this->Salary_Process->f_get_particulars("td_salary", $select, $where, 1);

                $data_array = array(
                    "trans_date"   =>  $trans_dt,
                    "trans_no"     => ($trans_no != NULL) ? ($trans_no->trans_no + 1) : '1',
                    "sal_month"    =>  $sal_month,
                    "sal_year"     =>  $year,
                    "catg_cd"      =>  $category,
                    "approval_status" => 'U',
                    "created_by"   =>  $this->session->userdata['loggedin']['user_id'],
                    "created_dt"   =>  date('Y-m-d h:i:s')
                );

                if ($this->Salary_Process->f_insert("td_salary", $data_array)) {
                    $emp_list = $this->Salary_Process->get_emp_dtls($category);
                    foreach ($emp_list as $emp) {
                        $er_table_name = 'td_income a';
                        $er_where = array(
                            'a.emp_code' => $emp->emp_code,
                            'a.effective_date = (SELECT MAX(c.effective_date) FROM td_income c)' => null
                        );
                        $erning_dt = $this->Admin_Process->f_get_particulars($er_table_name, null, $er_where, 1);

                        $de_table_name = 'td_deductions a';
                        $de_where = array(
                            'a.emp_code' => $emp->emp_code,
                            'a.effective_date = (SELECT MAX(c.effective_date) FROM td_deductions c)' => null
                        );
                        $deduction_dt = $this->Admin_Process->f_get_particulars($de_table_name, null, $de_where, 1);

                        $input = array(
                            'trans_date' => $trans_dt,
                            'trans_no' => $data_array['trans_no'],
                            'sal_month' => $sal_month,
                            'sal_year' => $year,
                            'emp_code' => $emp->emp_code,
                            'catg_id' => $category,
                            'basic' => $erning_dt->basic,
                            'ca' => $erning_dt->ca,
                            'da' => $erning_dt->da,
                            'ma' => $erning_dt->ma,
                            'ip' => $erning_dt->ip,
                            'fa' => $erning_dt->fa,
                            'hra' => $erning_dt->hra,
                            'dep' => $erning_dt->dep,
                            'oa' => $erning_dt->oa,
                            'bonus' => $erning_dt->bonus,
                            'exp' => $erning_dt->exp,
                            'ada' => $erning_dt->ada,
                            'lwp' => $erning_dt->lwp,
                            'final_gross' => $erning_dt->final_gross,
                            'tds' => $deduction_dt->tds,
                            'pf' => $deduction_dt->pf,
                            'giss' => $deduction_dt->giss,
                            'sss' => $deduction_dt->sss,
                            'fes_adv' => $deduction_dt->fes_adv,
                            'gsli' => $deduction_dt->gsli,
                            'hr' => $deduction_dt->hr,
                            'od' => $deduction_dt->od,
                            'dms_loan_prn' => $deduction_dt->dms_loan_prn,
                            'dms_loan_intt' => $deduction_dt->dms_loan_intt,
                            'hrep_1_loan_pr' => $deduction_dt->hrep_1_loan_pr,
                            'hrep_1_loan_intt' => $deduction_dt->hrep_1_loan_intt,
                            'hrep_2_loan_pr' => $deduction_dt->hrep_2_loan_pr,
                            'hrep_2_loan_intt' => $deduction_dt->hrep_2_loan_intt,
                            'p_tax' => $deduction_dt->p_tax,
                            'assn' => $deduction_dt->assn,
                            'ex_adj' => $deduction_dt->ex_adj,
                            'mr_loan_1_prn' => $deduction_dt->mr_loan_1_prn,
                            'mr_loan_1_intt' => $deduction_dt->mr_loan_1_intt,
                            'mr_loan_2_prn' => $deduction_dt->mr_loan_2_prn,
                            'mr_loan_2_intt' => $deduction_dt->mr_loan_2_intt,
                            'med_loan_prn' => $deduction_dt->med_loan_prn,
                            'med_loan_intt' => $deduction_dt->med_loan_intt,
                            'spl_med_loan_prn' => $deduction_dt->spl_med_loan_prn,
                            'spl_med_loan_intt' => $deduction_dt->spl_med_loan_intt,
                            'tot_diduction' => $deduction_dt->tot_diduction,
                            'net_sal' => $deduction_dt->net_sal,
                            'remarks' => 'System Generated',
                            'bank_ac_no' => $emp->bank_ac_no,
                            "created_by"   =>  $this->session->userdata['loggedin']['user_id'],
                            "created_dt"   =>  date('Y-m-d h:i:s')
                        );
                        // echo '<pre>';
                        // var_dump($input);
                        // exit;
                        $this->Salary_Process->f_insert("td_pay_slip", $input);
                    }
                }

                $this->session->set_flashdata('msg', 'Successfully generated!');
            }

            redirect('genspl');
        } else {

            //Month List
            $generation['month_list'] =   $this->Salary_Process->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $generation['sys_date']   =   $_SESSION['sys_date'];

            //Last payslip generation date
            $generation['generation_dtls']    =   $this->Salary_Process->f_get_generation();

            //Category List
            $generation['category']   =   $this->Salary_Process->f_get_particulars("md_category", NULL, NULL, 0);

            $this->load->view('post_login/payroll_main');

            $this->load->view("generation/add", $generation);

            $this->load->view('post_login/footer');
        }
    }






    /*************************REPORTS**************************/

    //For Categorywise Salary Report
    public function f_salary_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {


            //Employee Ids for Salary List
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  $this->input->post('category')

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for ($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);
            }


            //List of Salary Category wise
            unset($where);
            $where = array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year"      =>  $this->input->post('year')

            );

            $salary['list']               =   $this->Payroll->f_get_particulars_in("td_pay_slip", $eid_list, $where);

            $salary['attendance_dtls']    =   $this->Payroll->f_get_attendance();

            //Employee Group Count
            unset($select);
            unset($where);

            $select =   array(

                "emp_no", "emp_name", "COUNT(emp_name) count"

            );

            $where  =   array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year = '" . $this->input->post('year') . "' GROUP BY emp_no, emp_name"      =>  NULL

            );

            $salary['count']              =   $this->Payroll->f_get_particulars("td_pay_slip", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salary", $salary);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $salary['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $salary['sys_date']   =   $_SESSION['sys_date'];

            //Category List
            $salary['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salary", $salary);

            $this->load->view('post_login/footer');
        }
    }
    //////////////////////////////////////////////////////////////////////////
    public function f_salaryold_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {


            //Employee Ids for Salary List
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  $this->input->post('category')

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for ($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);
            }


            //List of Salary Category wise
            unset($where);
            $where = array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year"      =>  $this->input->post('year')

            );

            $salary['list']               =   $this->Payroll->f_get_particulars_in("td_pay_slip_old ", $eid_list, $where);

            $salary['attendance_dtls']    =   $this->Payroll->f_get_attendance();

            //Employee Group Count
            unset($select);
            unset($where);

            $select =   array(

                "emp_no", "emp_name", "COUNT(emp_name) count"

            );

            $where  =   array(

                "sal_month"     =>  $this->input->post('sal_month'),

                "sal_year = '" . $this->input->post('year') . "' GROUP BY emp_no, emp_name"      =>  NULL

            );

            $salary['count']              =   $this->Payroll->f_get_particulars("td_pay_slip_old ", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salaryold", $salary);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $salary['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $salary['sys_date']   =   $_SESSION['sys_date'];

            //Category List
            $salary['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/salaryold", $salary);

            $this->load->view('post_login/footer');
        }
    }
    //////////////////////////////////////////////////////////////////////////
    //For Payslip Report
    public function f_payslip_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //Payslip
            $where  =   array(

                "emp_no"            =>  $this->input->post('emp_cd'),

                "sal_month"         =>  $this->input->post('sal_month'),

                "sal_year"          =>  $this->input->post('year'),

                "approval_status"   =>  'A'

            );

            $payslip['emp_dtls']    =   $this->Payroll->f_get_particulars("md_employee", NULL, array("emp_code" =>  $this->input->post('emp_cd')), 1);

            $payslip['payslip_dtls'] =   $this->Payroll->f_get_particulars("td_pay_slip", NULL, $where, 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslip", $payslip);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $payslip['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $payslip['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            unset($select);
            $select = array("emp_code", "emp_name");

            $payslip['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, array("emp_catg IN (1,2,3)" => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslip", $payslip);

            $this->load->view('post_login/footer');
        }
    }

    //////////////////////////////////////////////////////////////////

    public function f_payslipold_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //Payslip
            $where  =   array(

                "emp_no"            =>  $this->input->post('emp_cd'),

                "sal_month"         =>  $this->input->post('sal_month'),

                "sal_year"          =>  $this->input->post('year'),

                "approval_status"   =>  'A'

            );

            $payslip['emp_dtls']    =   $this->Payroll->f_get_particulars("md_employee", NULL, array("emp_code" =>  $this->input->post('emp_cd')), 1);

            $payslip['payslip_dtls'] =   $this->Payroll->f_get_particulars("td_pay_slip_old ", NULL, $where, 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslipold", $payslip);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $payslip['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $payslip['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            unset($select);
            $select = array("emp_code", "emp_name");

            $payslip['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, array("emp_catg IN (1,2,3)" => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/payslipold", $payslip);

            $this->load->view('post_login/footer');
        }
    }

    //For Salary Statement
    public function f_statement_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employees salary statement
            $select = array(

                "m.emp_name", "m.bank_ac_no",

                "t.net_amount"

            );

            $where  = array(

                "m.emp_code = t.emp_no" =>  NULL,

                "t.sal_month"           =>  $this->input->post('sal_month'),

                "t.sal_year"            =>  $this->input->post('year'),

                "m.emp_catg"            =>  $this->input->post('category'),

                "m.emp_status"          =>  'A',

                "m.deduction_flag"      =>  'Y'

            );

            $statement['statement'] =   $this->Payroll->f_get_particulars("md_employee m, td_pay_slip t", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statement", $statement);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $statement['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //Category List
            $statement['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statement", $statement);

            $this->load->view('post_login/footer');
        }
    }
    //////////////////////////////////////
    public function f_statementold_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employees salary statement
            $select = array(

                "m.emp_name", "m.bank_ac_no",

                "t.net_amount"

            );

            $where  = array(

                "m.emp_code = t.emp_no" =>  NULL,

                "t.sal_month"           =>  $this->input->post('sal_month'),

                "t.sal_year"            =>  $this->input->post('year'),

                "m.emp_catg"            =>  $this->input->post('category'),

                "m.emp_status"          =>  'A',

                "m.deduction_flag"      =>  'Y'

            );

            $statement['statement'] =   $this->Payroll->f_get_particulars("md_employee m, td_pay_slip t", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statementold", $statement);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $statement['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //Category List
            $statement['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, array('category_code IN (1,2,3)' => NULL), 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/statementold", $statement);

            $this->load->view('post_login/footer');
        }
    }



    ////////////////////////////////////////

    //For Bonus Report
    public function f_bonus_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employee Ids for Bonus
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  $this->input->post('category')

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for ($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);
            }


            //List of Bonus Category wise
            unset($where);
            $where = array(

                "month"     =>  $this->input->post('month'),

                "year"      =>  $this->input->post('year')

            );

            $bonus['list']          =   $this->Payroll->f_get_particulars_in("td_bonus", $eid_list, $where);

            $bonus['bonus_dtls']    =   $this->Payroll->f_get_attendance();

            //Bonus Salary Range
            $bonus['bonus_range']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 14), 1);

            //Bonus Salary Year
            $bonus['bonus_year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/bonus", $bonus);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $bonus['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $bonus['sys_date']   =   $_SESSION['sys_date'];

            //Category List
            $bonus['category']   =   $this->Payroll->f_get_particulars("md_category", NULL, NULL, 0);


            $this->load->view('post_login/main');

            $this->load->view("reports/bonus", $bonus);

            $this->load->view('post_login/footer');
        }
    }


    //For Incentive Report
    public function f_incentive_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Employee Ids for Incentive
            $select     =   array("emp_code");

            $where      =   array(

                "emp_catg"  =>  4

            );

            $emp_id     =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            //Temp variable for emp_list
            $eid_list   =   [];

            for ($i = 0; $i < count($emp_id); $i++) {

                array_push($eid_list, $emp_id[$i]->emp_code);
            }


            //List of Incentive Category wise
            unset($where);
            $where = array(

                "month"     =>  $this->input->post('month'),

                "year"      =>  $this->input->post('year')

            );

            //Incentive list
            $incentive['list']          =   $this->Payroll->f_get_particulars_in("td_incentive", $eid_list, $where);

            //Incentive Year
            $incentive['incentive_year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/incentive", $incentive);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $incentive['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $incentive['sys_date']   =   $_SESSION['sys_date'];

            $this->load->view('post_login/main');

            $this->load->view("reports/incentive", $incentive);

            $this->load->view('post_login/footer');
        }
    }


    //Total Deduction Report

    public function f_totaldeduction_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $totaldeduction['total_deduct'] =   $this->Payroll->f_get_totaldeduction($this->input->post('from_date'), $this->input->post('to_date'));

            //Current Year
            $totaldeduction['year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/totaldeduction", $totaldeduction);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $totaldeduction['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $totaldeduction['sys_date']   =   $_SESSION['sys_date'];

            $this->load->view('post_login/main');

            $this->load->view("reports/totaldeduction", $totaldeduction);

            $this->load->view('post_login/footer');
        }
    }


    //PF Contribution Report
    public function f_pfcontribution_report()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Opening Balance Date
            $where  =   array(

                "emp_no"      => $this->input->post('emp_cd'),

                "trans_dt < " => $this->input->post("from_date")

            );

            //Max Transaction Date
            $max_trans_dt   =   $this->Payroll->f_get_particulars("tm_pf_dtls", array("MAX(trans_dt) trans_dt"), $where, 1);


            //temp variable
            $pfcontribution['pf_contribution']   =   NULL;

            if (!is_null($max_trans_dt->trans_dt)) {

                //Opening Balance
                $pfcontribution['opening_balance']   =   $this->Payroll->f_get_particulars("tm_pf_dtls", array("balance"), array("emp_no" => $this->input->post('emp_cd'), "trans_dt" => $max_trans_dt->trans_dt), 1);
            } else {

                //Opening Balance
                $pfcontribution['opening_balance']   =   0;
            }

            //PF Contribution List
            unset($where);
            $where  =   array(

                "emp_no"    => $this->input->post('emp_cd'),

                "trans_dt BETWEEN '" . $this->input->post("from_date") . "' AND '" . $this->input->post('to_date') . "'" => NULL

            );

            $pfcontribution['pf_contribution']   =   $this->Payroll->f_get_particulars("tm_pf_dtls", NULL, $where, 0);


            //Current Year
            $pfcontribution['year']  =   $this->Payroll->f_get_particulars("md_parameters", array('param_value'), array('sl_no' => 15), 1);

            //Employee Name
            $pfcontribution['emp_name']  =   $this->Payroll->f_get_particulars("md_employee", array('emp_name'), array('emp_code' => $this->input->post('emp_cd')), 1);

            $this->load->view('post_login/main');

            $this->load->view("reports/pfcontribution", $pfcontribution);

            $this->load->view('post_login/footer');
        } else {

            //Month List
            $pfcontribution['month_list'] =   $this->Payroll->f_get_particulars("md_month", NULL, NULL, 0);

            //For Current Date
            $pfcontribution['sys_date']   =   $_SESSION['sys_date'];

            //Employee List
            $select =   array("emp_code", "emp_name");

            $where  =   array(

                "emp_catg IN (1,2,3)"      => NULL,

                "deduction_flag"           => "Y"
            );

            $pfcontribution['emp_list']   =   $this->Payroll->f_get_particulars("md_employee", $select, $where, 0);

            $this->load->view('post_login/main');

            $this->load->view("reports/pfcontribution", $pfcontribution);

            $this->load->view('post_login/footer');
        }
    }
}
