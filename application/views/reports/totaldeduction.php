<script>
  function printDiv() {

    var divToPrint = document.getElementById('divToPrint');

    var WindowObject = window.open('', 'Print-Window');
    WindowObject.document.open();
    WindowObject.document.writeln('<!DOCTYPE html>');
    WindowObject.document.writeln('<html><head><title></title><style type="text/css">');


    WindowObject.document.writeln('@media print { .center { text-align: center;}' +
      '                                         .inline { display: inline; }' +
      '                                         .underline { text-decoration: underline; }' +
      '                                         .left { margin-left: 315px;} ' +
      '                                         .right { margin-right: 375px; display: inline; }' +
      '                                          table { border-collapse: collapse; }' +
      '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 10px;}' +
      '                                           th, td { }' +
      '                                         .border { border: 1px solid black; } ' +
      '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
      '                                       ' +
      '                                   } } </style>');
    WindowObject.document.writeln('</head><body onload="window.print()">');
    WindowObject.document.writeln(divToPrint.innerHTML);
    WindowObject.document.writeln('</body></html>');
    WindowObject.document.close();
    setTimeout(function() {
      WindowObject.close();
    }, 10);

  }
</script>

<style>
  th {
    text-align: center;
    vertical-align: middle !important;
  }
</style>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $tot_tds = 0;
  $tot_pf = 0;
  $tot_giss = 0;
  $tot_sss = 0;
  $tot_fes_adv = 0;
  $tot_gsli = 0;
  $tot_hr = 0;
  $tot_od = 0;
  $tot_dms_loan_prn = 0;
  $tot_dms_loan_intt = 0;
  $tot_hrep_1_loan_pr = 0;
  $tot_hrep_1_loan_intt = 0;
  $tot_hrep_2_loan_pr = 0;
  $tot_hrep_2_loan_intt = 0;
  $tot_hrep_2_loan_pr = 0;
  $tot_hrep_2_loan_intt = 0;
  $tot_p_tax = 0;
  $tot_assn = 0;
  $tot_ex_adj = 0;
  $tot_mr_loan_1_prn = 0;
  $tot_mr_loan_1_intt = 0;
  $tot_mr_loan_2_prn = 0;
  $tot_mr_loan_2_intt = 0;
  $tot_med_loan_prn = 0;
  $tot_med_loan_intt = 0;
  $tot_spl_med_loan_prn = 0;
  $tot_spl_med_loan_intt = 0;
  $tot_tot_diduction = 0;
?>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body" id='divToPrint'>
          <center>
          <div class="row">
          <div class="col-2 payslip_logo_Uts"><a href="javascript:void()"><img src="<?= base_url() ?>assets/images/benfed.png" alt="logo" /></a></div>
            <div class="col-10 payslip_logo_Desc_Uts">
              <h3>Dakshin Dinajpur Co-op Agri. & Rural Dev. Bank Ltd.</h3>
              <h4>P.O. Balurghat, Dist. Dakshin Dinajpur</h4>
              <h4>Total deduction of Regular employees From <?php echo date('d/m/Y', strtotime($this->input->post('from_date'))) . ' To ' . date('d/m/Y', strtotime($this->input->post('to_date'))); ?>
                <!-- <h4>Pay Slip for <?php //echo date($this->input->post('sal_month'), "d/m/Y") . '-' . $this->input->post('year'); 
                                      ?></h4> -->
              </h4>
            </div>
          </div>
          </center>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">

                  <thead>

                    <tr>
                      <th>Sl No.</th>
                      <th>Name of Emplyees</th>
                      <th>TDS</th>
                      <th>P.F.</th>
                      <th>GISS</th>
                      <th>Salary Savings Scheme</th>
                      <th>Festival Advance</th>
                      <th>GSLI</th>
                      <th>House Rent</th>
                      <th>Other Deduction</th>
                      <th>DMS Loan Prin.</th>
                      <th>DMS Loan Intt.</th>
                      <th>House Rep. 1 Loan Prin.</th>
                      <th>House Rep. 1 Loan Intt.</th>
                      <th>House Rep. 2 Loan Prin.</th>
                      <th>House Rep. 2 Loan Intt.</th>
                      <th>Professional Tax</th>
                      <th>ASSN</th>
                      <th>Excess Adjustment</th>
                      <th>Marriage Loan 1 Prin.</th>
                      <th>Marriage Loan 1 Intt.</th>
                      <th>Marriage Loan 2 Prin.</th>
                      <th>Marriage Loan 2 Intt.</th>
                      <th>Medical Loan Prin.</th>
                      <th>Medical Loan Intt.</th>
                      <th>Spl Med Loan Prin.</th>
                      <th>Spl Med Loan Intt.</th>
                      <th>Total <br>Deduction</th>
                    </tr>

                  </thead>

                  <tbody>

                    <?php

                    if ($total_deduct) {

                      $i  =   1;

                      // $tot_ins = $tot_css = $tot_hbl = $tot_tel = $tot_med_adv = $tot_fa = $tot_tf = $tot_med_ins = $tot_comp_loan = $tot_ptax = $tot_itax = $tot_gpf = $tot_epf = $tot_other_deduction = 0;

                      foreach ($total_deduct as $td_list) {
                        $tot_tds += $td_list->tds;
                        $tot_pf += $td_list->pf;
                        $tot_giss += $td_list->giss;
                        $tot_sss += $td_list->sss;
                        $tot_fes_adv += $td_list->fes_adv;
                        $tot_gsli += $td_list->gsli;
                        $tot_hr += $td_list->hr;
                        $tot_od += $td_list->od;
                        $tot_dms_loan_prn += $td_list->dms_loan_prn;
                        $tot_dms_loan_intt += $td_list->dms_loan_intt;
                        $tot_hrep_1_loan_pr += $td_list->hrep_1_loan_pr;
                        $tot_hrep_1_loan_intt += $td_list->hrep_1_loan_intt;
                        $tot_hrep_2_loan_pr += $td_list->hrep_2_loan_pr;
                        $tot_hrep_2_loan_intt += $td_list->hrep_2_loan_intt;
                        $tot_p_tax += $td_list->p_tax;
                        $tot_assn += $td_list->assn;
                        $tot_ex_adj += $td_list->ex_adj;
                        $tot_mr_loan_1_prn += $td_list->mr_loan_1_prn;
                        $tot_mr_loan_1_intt += $td_list->mr_loan_1_intt;
                        $tot_mr_loan_2_prn += $td_list->mr_loan_2_prn;
                        $tot_mr_loan_2_intt += $td_list->mr_loan_2_intt;
                        $tot_med_loan_prn += $td_list->med_loan_prn;
                        $tot_med_loan_intt += $td_list->med_loan_intt;
                        $tot_spl_med_loan_prn += $td_list->spl_med_loan_prn;
                        $tot_spl_med_loan_intt += $td_list->spl_med_loan_intt;
                        $tot_tot_diduction += $td_list->tot_diduction;
                    ?>

                        <tr>

                          <td><?= $i++; ?></td>

                          <td><?= $td_list->emp_name; ?></td>
                          <td><?= $td_list->tds; ?></td>
                          <td><?= $td_list->pf; ?></td>
                          <td><?= $td_list->giss; ?></td>
                          <td><?= $td_list->sss; ?></td>
                          <td><?= $td_list->fes_adv; ?></td>
                          <td><?= $td_list->gsli; ?></td>
                          <td><?= $td_list->hr; ?></td>
                          <td><?= $td_list->od; ?></td>
                          <td><?= $td_list->dms_loan_prn; ?></td>
                          <td><?= $td_list->dms_loan_intt; ?></td>
                          <td><?= $td_list->hrep_1_loan_pr; ?></td>
                          <td><?= $td_list->hrep_1_loan_intt; ?></td>
                          <td><?= $td_list->hrep_2_loan_pr; ?></td>
                          <td><?= $td_list->hrep_2_loan_intt; ?></td>
                          <td><?= $td_list->p_tax; ?></td>
                          <td><?= $td_list->assn; ?></td>
                          <td><?= $td_list->ex_adj; ?></td>
                          <td><?= $td_list->mr_loan_1_prn; ?></td>
                          <td><?= $td_list->mr_loan_1_intt; ?></td>
                          <td><?= $td_list->mr_loan_2_prn; ?></td>
                          <td><?= $td_list->mr_loan_2_intt; ?></td>
                          <td><?= $td_list->med_loan_prn; ?></td>
                          <td><?= $td_list->med_loan_intt; ?></td>
                          <td><?= $td_list->spl_med_loan_prn; ?></td>
                          <td><?= $td_list->spl_med_loan_intt; ?></td>
                          <td><?= $td_list->tot_diduction; ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                      <tr>
                        <td colspan="2">Total Amount</td>
                        <td><?= $tot_tds ?></td>
                        <td><?= $tot_pf ?></td>
                        <td><?= $tot_giss ?></td>
                        <td><?= $tot_sss ?></td>
                        <td><?= $tot_fes_adv ?></td>
                        <td><?= $tot_gsli ?></td>
                        <td><?= $tot_hr ?></td>
                        <td><?= $tot_od ?></td>
                        <td><?= $tot_dms_loan_prn ?></td>
                        <td><?= $tot_dms_loan_intt ?></td>
                        <td><?= $tot_hrep_1_loan_pr ?></td>
                        <td><?= $tot_hrep_1_loan_intt ?></td>
                        <td><?= $tot_hrep_2_loan_pr ?></td>
                        <td><?= $tot_hrep_2_loan_intt ?></td>
                        <td><?= $tot_p_tax ?></td>
                        <td><?= $tot_assn ?></td>
                        <td><?= $tot_ex_adj ?></td>
                        <td><?= $tot_mr_loan_1_prn ?></td>
                        <td><?= $tot_mr_loan_1_intt ?></td>
                        <td><?= $tot_mr_loan_2_prn ?></td>
                        <td><?= $tot_mr_loan_2_intt ?></td>
                        <td><?= $tot_med_loan_prn ?></td>
                        <td><?= $tot_med_loan_intt ?></td>
                        <td><?= $tot_spl_med_loan_prn ?></td>
                        <td><?= $tot_spl_med_loan_intt ?></td>
                        <td><?= $tot_tot_diduction ?></td>
                      </tr>
                    <?php

                    } else {

                      echo "<tr><td colspan='28' style='text-align:center;'>No Data Found</td></tr>";
                    }
                    ?>

                  </tbody>

                </table>
                <br>
                <div>

                </div>

                <div class="bottom">

                  <p style="display: inline;">Prepared By</p>

                  <p style="display: inline; margin-left: 8%;">Establishment, Sr. Asstt.</p>

                  <p style="display: inline; margin-left: 8%;">Assistant Manager-II</p>

                  <p style="display: inline; margin-left: 8%;">Chief Executive officer</p>

                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
	  <center>
        <button type='button' class="btn btn-primary mt-3" onclick='printDiv();'>Print</button>
      </center>
    </div>



  <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  ?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="card">
          <div class="card-body">
            <h3>Deduction Report</h3>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form method="POST" id="form" action="<?php echo site_url("reports/totaldeduction"); ?>">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-6">
                            <label for="exampleInputName1">From Date:</label>
                            <input type="date" name="from_date" class="form-control required" id="from_date" value="<?php echo $sys_date; ?>" />
                          </div>
                          <div class="col-6">
                            <label for="exampleInputName1">To Date:</label>
                            <input type="date" name="to_date" class="form-control required" id="to_date" value="<?php echo $sys_date; ?>" />


                          </div>
                        </div>
                      </div>

                      <input type="submit" class="btn btn-info" value="Proceed" />
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    <?php

  } else {

    echo "<h1 style='text-align: center;'>No Data Found</h1>";
  }

    ?>