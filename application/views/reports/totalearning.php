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
              <h4>Total earning of Regular employees From <?php echo date('d/m/Y', strtotime($this->input->post('from_date'))) . ' To ' . date('d/m/Y', strtotime($this->input->post('to_date'))); ?>
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
                      <th>D.A.</th>
                      <th>H.R.A.</th>
                      <th>M.A.</th>
                      <th>C.A.</th>
                      <th>I.P.</th>
                      <th>F.A.</th>
                      <th>Deputation</th>
                      <th>O.A.</th>
                      <th>Bonus</th>
                      <th>Excess</th>
                      <th>Area D.A.</th>
                      <th>LWP</th> 
                      <th>Final Gross</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($total_ear) {
                      $i  =   1;
                      $tot_da = 0;
                      $tot_hra = 0;
                      $tot_ma = 0;
                      $tot_ca = 0;
                      $tot_ip = 0;
                      $tot_fa = 0;
                      $tot_dep = 0;
                      $tot_oa = 0;
                      $tot_bonus = 0;
                      $tot_exp = 0;
                      $tot_ada = 0;
                      $tot_lwp = 0;
                      $tot_final_gross = 0;
                      foreach ($total_ear as $td_list) {
                        $tot_da += $td_list->da;
                        $tot_hra += $td_list->hra;
                        $tot_ma += $td_list->ma;
                        $tot_ca += $td_list->ca;
                        $tot_ip += $td_list->ip;
                        $tot_fa += $td_list->fa;
                        $tot_dep += $td_list->dep;
                        $tot_oa += $td_list->oa;
                        $tot_bonus += $td_list->bonus;
                        $tot_exp += $td_list->exp;
                        $tot_ada += $td_list->ada;
                        $tot_lwp += $td_list->lwp;
                        $tot_final_gross += $td_list->final_gross;

                    ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $td_list->emp_name; ?></td>
                          <td><?= $td_list->da; ?></td>
                          <td><?= $td_list->hra; ?></td>
                          <td><?= $td_list->ma; ?></td>
                          <td><?= $td_list->ca; ?></td>
                          <td><?= $td_list->ip; ?></td>
                          <td><?= $td_list->fa; ?></td>
                          <td><?= $td_list->dep; ?></td>
                          <td><?= $td_list->oa; ?></td>
                          <td><?= $td_list->bonus; ?></td>
                          <td><?= $td_list->exp; ?></td>
                          <td><?= $td_list->ada; ?></td>
                          <td><?= $td_list->lwp; ?></td>
                          <td><?= $td_list->final_gross; ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                      <tr>
                        <td colspan="2">Total Amount</td>
                        <td><?= $tot_da ?></td>
                        <td><?= $tot_hra ?></td>
                        <td><?= $tot_ma ?></td>
                        <td><?= $tot_ca ?></td>
                        <td><?= $tot_ip ?></td>
                        <td><?= $tot_fa ?></td>
                        <td><?= $tot_dep ?></td>
                        <td><?= $tot_oa ?></td>
                        <td><?= $tot_bonus ?></td>
                        <td><?= $tot_exp ?></td>
                        <td><?= $tot_ada ?></td>
                        <td><?= $tot_lwp; ?></td>
                        <td><?= $tot_final_gross; ?></td>
                      </tr>
                    <?php
                    } else {
                      echo "<tr><td colspan='9' style='text-align:center;'>No Data Found</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
                <br>
                <div>
		</div>
                <div class="bottom">
                  <p style="display: inline;">Prepared By</p>
                  <p style="display: inline; margin-left: 8%;">Accountent</p>
                  <p style="display: inline; margin-left: 8%;">Manager</p>
                  <p style="display: inline; margin-left: 8%;">Secretary</p>
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
            <h3>Earning Report</h3>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form method="POST" id="form" action="<?php echo site_url("reports/totalearning"); ?>">
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