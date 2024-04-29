<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_Process extends CI_Model
{

	public function f_get_particulars($table_name, $select = NULL, $where = NULL, $flag)
	{

		if (isset($select)) {

			$this->db->select($select);
		}

		if (isset($where)) {

			$this->db->where($where);
		}

		$result		=	$this->db->get($table_name);

		if ($flag == 1) {

			return $result->row();
		} else {

			return $result->result();
		}
	}


	public function f_get_particulars_in($table_name, $where_in = NULL, $where = NULL)
	{

		if (isset($where)) {

			$this->db->where($where);
		}

		if (isset($where_in)) {

			$this->db->where_in('emp_no', $where_in);
		}

		$result	=	$this->db->get($table_name);

		return $result->result();
	}
	public function f_edit($table_name, $data_array, $where)
	{

		$this->db->where($where);
		$this->db->update($table_name, $data_array);

		return;
	}

	//For inserting row
	public function f_insert($table_name, $data_array)
	{

		$this->db->insert($table_name, $data_array);

		return;
	}

	//For Deliting row
	public function f_delete($table_name, $where)
	{

		$this->db->delete($table_name, $where);

		return;
	}

	public function f_get_totaldeduction($from_date, $to_date)
	{
		$this->db->select('a.emp_code, SUM(a.tds) tds, SUM(a.pf)pf, SUM(a.giss)giss, SUM(a.sss)sss, SUM(a.fes_adv)fes_adv, SUM(a.gsli)gsli, SUM(a.hr)hr, SUM(a.od)od, SUM(a.dms_loan_prn)dms_loan_prn, SUM(a.dms_loan_intt)dms_loan_intt, SUM(a.hrep_1_loan_pr)hrep_1_loan_pr, SUM(a.hrep_1_loan_intt)hrep_1_loan_intt, SUM(a.hrep_2_loan_pr)hrep_2_loan_pr, SUM(a.hrep_2_loan_intt)hrep_2_loan_intt,SUM(a.p_tax)p_tax, SUM(a.assn)assn,SUM(a.ex_adj)ex_adj, SUM(a.mr_loan_1_prn)mr_loan_1_prn,SUM(a.mr_loan_1_intt)mr_loan_1_intt, SUM(a.mr_loan_2_prn)mr_loan_2_prn,SUM(a.mr_loan_2_intt)mr_loan_2_intt, SUM(a.med_loan_prn)med_loan_prn,SUM(a.med_loan_intt)med_loan_intt, SUM(a.spl_med_loan_prn)spl_med_loan_prn,SUM(a.spl_med_loan_intt)spl_med_loan_intt, SUM(a.tot_diduction)tot_diduction, b.emp_name');
		$this->db->where(array(
			'a.emp_code=b.emp_code' => null,
			'a.sal_month BETWEEN ' . date('m', strtotime($from_date)) . ' AND ' . date('m', strtotime($to_date)) => null
			// 'a.trans_date <=' => $from_date,
			// 'a.trans_date >=' => $to_date
		));
		$this->db->group_by('a.emp_code');
		$query = $this->db->get('td_pay_slip a, md_employee b');
		return $query->result();
	}

	public function f_get_totalearning($from_date, $to_date)
	{
		$this->db->select('a.emp_code, SUM(a.ca) ca, SUM(a.da) da, SUM(a.ma) ma, SUM(a.ip) ip, 
		SUM(a.fa) fa, SUM(a.hra) hra, SUM(a.dep) dep, SUM(a.oa) oa, SUM(a.bonus) bonus, SUM(a.exp) exp, SUM(a.ada) ada, b.emp_name, SUM(a.lwp) lwp, SUM(a.final_gross) final_gross');
		$this->db->where(array(
			'a.emp_code=b.emp_code' => null,
			'a.sal_month BETWEEN ' . date('m', strtotime($from_date)) . ' AND ' . date('m', strtotime($to_date)) => null
		));
		$this->db->group_by('a.emp_code');
		$query = $this->db->get('td_pay_slip a, md_employee b');
		//echo $this->db->last_query();exit;
		return $query->result();
	}

	public function f_get_emp_dtls($empno, $sal_month, $sal_yr)
	{

		$result = $this->db->query("select a.*, b.emp_name,b.designation,b.phn_no,b.department,b.pan_no
			  from 
			  td_pay_slip a,md_employee b where a.emp_code=b.emp_code and a.emp_code = $empno
			  and a.sal_month=$sal_month and a.sal_year=$sal_yr ");

		//$result	=	$this->db->query($sql);

		return $result->row();
	}


	public function f_count_emp($emp_code)
	{

		$result = $this->db->query("select count(*)count_emp from md_employee where emp_code = $emp_code");

		//$result	=	$this->db->query($sql);

		return $result->row();
	}
}
