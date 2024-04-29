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
            '                                          th { text-align: center; vertical-align: middle; }' +
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
                    <div class="row">
                        <div class="col-1"><a href="javascript:void()"><img src="<?= base_url() ?>assets/images/benfed.png" alt="logo" /></a></div>
                        <div class="col-10">
                            <div style="text-align:center;">
                                <h3>Dakshin Dinajpur Co-op Agri. & Rural Dev. Bank Ltd.</h3>
                                <h4>38JC+226, Kalindibandh, Bishnupur, West Bengal 722122</h4>
                                <h4>Salary summary report for the month of <?php echo MONTHS[$this->input->post('sal_month')] . ' ' . $this->input->post('year'); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Name</th>
                                            <th>Basic Pay</th>
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
                                            <th>Net Amount</th>
                                            <th>Bank A/C No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($statement) {
                                            $i  =   1;
                                            $tot_net = 0;
                                            foreach ($statement as $s_list) {
                                                $tot_net += $s_list->net_sal;
                                        ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $s_list->emp_name; ?></td>
                                                    <td><?= $s_list->basic; ?></td>
                                                    <td><?= $s_list->da; ?></td>
                                                    <td><?= $s_list->hra; ?></td>
                                                    <td><?= $s_list->ma; ?></td>
                                                    <td><?= $s_list->ca; ?></td>
                                                    <td><?= $s_list->ip; ?></td>
                                                    <td><?= $s_list->fa; ?></td>
                                                    <td><?= $s_list->dep; ?></td>
                                                    <td><?= $s_list->oa; ?></td>
                                                    <td><?= $s_list->bonus; ?></td>
                                                    <td><?= $s_list->exp; ?></td>
                                                    <td><?= $s_list->ada; ?></td>
                                                    <td><?= $s_list->tds; ?></td>
                                                    <td><?= $s_list->pf; ?></td>
                                                    <td><?= $s_list->giss; ?></td>
                                                    <td><?= $s_list->sss; ?></td>
                                                    <td><?= $s_list->fa; ?></td>
                                                    <td><?= $s_list->gsli; ?></td>
                                                    <td><?= $s_list->hr; ?></td>
                                                    <td><?= $s_list->od; ?></td>
                                                    <td><?= $s_list->dms_loan_prn; ?></td>
                                                    <td><?= $s_list->dms_loan_intt; ?></td>
                                                    <td><?= $s_list->hrep_1_loan_pr; ?></td>
                                                    <td><?= $s_list->hrep_1_loan_intt; ?></td>
                                                    <td><?= $s_list->hrep_2_loan_pr; ?></td>
                                                    <td><?= $s_list->hrep_2_loan_intt; ?></td>
                                                    <td><?= $s_list->p_tax; ?></td>
                                                    <td><?= $s_list->assn; ?></td>
                                                    <td><?= $s_list->ex_adj; ?></td>
                                                    <td><?= $s_list->mr_loan_1_prn; ?></td>
                                                    <td><?= $s_list->mr_loan_1_intt; ?></td>
                                                    <td><?= $s_list->mr_loan_2_prn; ?></td>
                                                    <td><?= $s_list->mr_loan_2_intt; ?></td>
                                                    <td><?= $s_list->med_loan_prn; ?></td>
                                                    <td><?= $s_list->med_loan_intt; ?></td>
                                                    <td><?= $s_list->spl_med_loan_prn; ?></td>
                                                    <td><?= $s_list->spl_med_loan_intt; ?></td>
                                                    <td><?= $s_list->tot_diduction; ?></td>
                                                    <td><?= $s_list->net_sal; ?></td>
                                                    <td><?= $s_list->bank_ac_no; ?></td>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="3">Total Amount</td>
                                                <td style="text-align: right;"> Rs. <?php echo $tot_net; ?></td>
                                            </tr>
                                        <?php
                                        } else {
                                            echo "<tr><td colspan='32' style='text-align:center;'>No Data Found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <br>
                                <div>
                                    <p>Amount: <?php echo @$tot_net . ' (' . getIndianCurrency(@$tot_net > 0 ? $tot_net : 0.00) . ').'; ?></p>
                                </div>

                                <div class="bottom">
                                    <p style="display: inline;">Prepared By</p>
                                    <p style="display: inline; margin-left: 8%;"></p>
                                    <p style="display: inline; margin-left: 8%;"></p>
                                    <p style="display: inline; margin-left: 8%;">Chief Executive officer</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <input type='button' id='btn' value='Print' onclick='printDiv();'>
            </div>
        </div>



    <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h3>Salary Statement Report</h3>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form" action="<?php echo site_url("reports/paystatementreport"); ?>">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="exampleInputName1">From Date:</label>
                                                        <input type="date" name="from_date" class="form-control required" id="from_date" value="<?php echo $this->session->userdata('sys_date'); ?>" />
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="exampleInputName1">Select Month:</label>
                                                        <select class="form-control" name="sal_month" id="sal_month" require>
                                                            <option value="">Select Month</option>
                                                            <?php foreach ($month_list as $m_list) { ?>

                                                                <option value="<?php echo $m_list->id ?>"><?php echo $m_list->month_name; ?></option>

                                                            <?php
                                                            }
                                                            ?>

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="exampleInputName1">Input Year:</label>
                                                        <input type="text" class="form-control" name="year" id="year" value="<?php echo date('Y'); ?>" require />
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="exampleInputName1">Category:</label>
                                                        <select class="form-control required" name="category" id="category" require>

                                                            <option value="">Select Category</option>

                                                            <?php foreach ($category as $c_list) { ?>

                                                                <option value="<?php echo $c_list->id; ?>"><?php echo $c_list->category; ?></option>

                                                            <?php
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="submit" class="btn btn-info" value="Proceed" onclick="return checkVal();" />
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

        <script>
            function checkVal() {
                var month = $('#sal_month').val();
                var catg_id = $('#category').val();
                if (month > 0 && catg_id > 0) {
                    return true;
                } else {
                    alert('Please fill all fields')
                    return false;
                }
            }
        </script>