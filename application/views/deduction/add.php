<style>
    .table td .form-group {
        width: 165px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper content_wrapper_custom">
        <div class="card">
            <div class="card-body">
                <h3>Add Deductions</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("slrydedad"); ?>?catg_id=<?= $selected['catg_id'] ?>&sys_dt=<?= $selected['sal_date'] ?>&flag=<?= $selected['sal_flag'] ?>">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5">
                                                <label for="exampleInputName1">Date:</label>
                                                <input type="date" name="sal_date" class="form-control required" id="sal_date" value="<?= $selected['sal_date']; ?>" />
                                            </div>
                                            <div class="col-5">
                                                <label for="exampleInputName1">Category:</label>
                                                <select class="form-control required" name="catg_id" id="catg_id">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    if ($catg_list) {
                                                        $select = '';
                                                        foreach ($catg_list as $catg) {
                                                            if ($selected['catg_id'] == $catg->id) {
                                                                $select = 'selected';
                                                            } else {
                                                                $select = '';
                                                            } ?>
                                                            <option value="<?= $catg->id ?>" <?= $select ?>><?= $catg->category; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-2 float-right">
                                                <label for="exampleInputName1">&nbsp;</label>
                                                <button type="submit" id="submit" name="submit" class="btn btn-primary mr-2 form-control">Populate</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php if (isset($_REQUEST['submit'])) {
            $display = '';
            $disabled = '';
            if ($selected['catg_id'] == 2) {
                $display = 'style="display:none;"';
            } ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h3>Add Deductions</h3>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body card_bodyCustom">
                                    <form method="POST" id="form" action="<?php echo site_url("slrydedsv"); ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive" id='permanent'>

                                                    <table class="table table-bordered">
                                                        <thead class="fixedHeaderTable">
                                                            <tr>
                                                                <th>Employee</th>
                                                                <th>GROSS SALARY</th>
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
                                                                <th>Total Deduction</th>
                                                                <th style="display: none;">NET SALARY</th>
                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
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
                                                            $tot_net_sal = 0;
                                                            if ($sal_list) {
                                                                $i = 0;
                                                                // var_dump($sal_list);exit;
                                                                foreach ($sal_list as $sal) {
                                                                    if ($sal['gross'] > 0) {
                                                                        $tot_tds += $sal['tds'];
                                                                        $tot_pf += $sal['pf'];
                                                                        $tot_giss += $sal['giss'];
                                                                        $tot_sss += $sal['sss'];
                                                                        $tot_fes_adv += $sal['fes_adv'];
                                                                        $tot_gsli += $sal['gsli'];
                                                                        $tot_hr += $sal['hr'];
                                                                        $tot_od += $sal['od'];
                                                                        $tot_dms_loan_prn += $sal['dms_loan_prn'];
                                                                        $tot_dms_loan_intt += $sal['dms_loan_intt'];
                                                                        $tot_hrep_1_loan_pr += $sal['hrep_1_loan_pr'];
                                                                        $tot_hrep_1_loan_intt += $sal['hrep_1_loan_intt'];
                                                                        $tot_hrep_2_loan_pr += $sal['hrep_2_loan_pr'];
                                                                        $tot_hrep_2_loan_intt += $sal['hrep_2_loan_intt'];
                                                                        $tot_p_tax += $sal['p_tax'];
                                                                        $tot_assn += $sal['assn'];
                                                                        $tot_ex_adj += $sal['ex_adj'];
                                                                        $tot_mr_loan_1_prn += $sal['mr_loan_1_prn'];
                                                                        $tot_mr_loan_1_intt += $sal['mr_loan_1_intt'];
                                                                        $tot_mr_loan_2_prn += $sal['mr_loan_2_prn'];
                                                                        $tot_mr_loan_2_intt += $sal['mr_loan_2_intt'];
                                                                        $tot_med_loan_prn += $sal['med_loan_prn'];
                                                                        $tot_med_loan_intt += $sal['med_loan_intt'];
                                                                        $tot_spl_med_loan_prn += $sal['spl_med_loan_prn'];
                                                                        $tot_spl_med_loan_intt += $sal['spl_med_loan_intt'];
                                                                        $tot_tot_diduction += $sal['tot_diduction'];
                                                                        $tot_net_sal += $sal['net_sal'];
                                                                    }
                                                                    if ($sal['gross'] == 'Fill Income First') {
                                                                        $disabled = 'disabled';
                                                                    } ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="emp_name[]" id="emp_name_<?= $i ?>" value="<?= $sal['emp_name']; ?>" readonly/>
                                                                                <input type="hidden" name="emp_code[]" id="emp_code_<?= $i ?>" value="<?= $sal['emp_code'] ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="gross[]" id="gross_<?= $i ?>" value="<?= $sal['gross']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="tds[]" id="tds_<?= $i ?>" value="<?= $sal['tds']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="pf[]" id="pf_<?= $i ?>" value="<?= $sal['pf']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly/>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="giss[]" id="giss_<?= $i ?>" value="<?= $sal['giss']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="sss[]" id="sss_<?= $i ?>" value="<?= $sal['sss']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="fes_adv[]" id="fes_adv_<?= $i ?>" value="<?= $sal['fes_adv']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="gsli[]" id="gsli_<?= $i ?>" value="<?= $sal['gsli']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="hr[]" id="hr_<?= $i ?>" value="<?= $sal['hr']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="od[]" id="od_<?= $i ?>" value="<?= $sal['od']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="dms_loan_prn[]" id="dms_loan_prn_<?= $i ?>" value="<?= $sal['dms_loan_prn']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="dms_loan_intt[]" id="dms_loan_intt_<?= $i ?>" value="<?= $sal['dms_loan_intt']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="hrep_1_loan_pr[]" id="hrep_1_loan_pr_<?= $i ?>" value="<?= $sal['hrep_1_loan_pr']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="hrep_1_loan_intt[]" id="hrep_1_loan_intt_<?= $i ?>" value="<?= $sal['hrep_1_loan_intt']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="hrep_2_loan_pr[]" id="hrep_2_loan_pr_<?= $i ?>" value="<?= $sal['hrep_2_loan_pr']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="hrep_2_loan_intt[]" id="hrep_2_loan_intt_<?= $i ?>" value="<?= $sal['hrep_2_loan_intt']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="p_tax[]" id="p_tax_<?= $i ?>" value="<?= $sal['p_tax']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly/>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="assn[]" id="assn_<?= $i ?>" value="<?= $sal['assn']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="ex_adj[]" id="ex_adj_<?= $i ?>" value="<?= $sal['ex_adj']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="mr_loan_1_prn[]" id="mr_loan_1_prn_<?= $i ?>" value="<?= $sal['mr_loan_1_prn']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="mr_loan_1_intt[]" id="mr_loan_1_intt_<?= $i ?>" value="<?= $sal['mr_loan_1_intt']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="mr_loan_2_prn[]" id="mr_loan_2_prn_<?= $i ?>" value="<?= $sal['mr_loan_2_prn']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="mr_loan_2_intt[]" id="mr_loan_2_intt_<?= $i ?>" value="<?= $sal['mr_loan_2_intt']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="med_loan_prn[]" id="med_loan_prn_<?= $i ?>" value="<?= $sal['med_loan_prn']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="med_loan_intt[]" id="med_loan_intt_<?= $i ?>" value="<?= $sal['med_loan_intt']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="spl_med_loan_prn[]" id="spl_med_loan_prn_<?= $i ?>" value="<?= $sal['spl_med_loan_prn']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="spl_med_loan_intt[]" id="spl_med_loan_intt_<?= $i ?>" value="<?= $sal['spl_med_loan_intt']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="tot_diduction[]" id="tot_diduction_<?= $i ?>" value="<?= $sal['tot_diduction']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly/>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="net_sal[]" id="net_sal_<?= $i ?>" value="<?= $sal['net_sal']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly/>
                                                                            </div>
                                                                        </td>

                                                                    </tr>
                                                            <?php $i++;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="2">TOTAL: </td>
                                                                <td><span id="tot_tds"><?= $tot_tds ?></span></td>
                                                                <td><span id="tot_pf"><?= $tot_pf ?></span></td>
                                                                <td><span id="tot_giss"><?= $tot_giss ?></span></td>
                                                                <td><span id="tot_sss"><?= $tot_sss ?></span></td>
                                                                <td><span id="tot_fes_adv"><?= $tot_fes_adv ?></span></td>
                                                                <td><span id="tot_gsli"><?= $tot_gsli ?></span></td>
                                                                <td><span id="tot_hr"><?= $tot_hr ?></span></td>
                                                                <td><span id="tot_od"><?= $tot_od ?></span></td>
                                                                <td><span id="tot_dms_loan_prn"><?= $tot_dms_loan_prn ?></span></td>
                                                                <td><span id="tot_dms_loan_intt"><?= $tot_dms_loan_intt ?></span></td>
                                                                <td><span id="tot_hrep_1_loan_pr"><?= $tot_hrep_1_loan_pr ?></span></td>
                                                                <td><span id="tot_hrep_1_loan_intt"><?= $tot_hrep_1_loan_intt ?></span></td>
                                                                <td><span id="tot_hrep_2_loan_pr"><?= $tot_hrep_2_loan_pr ?></span></td>
                                                                <td><span id="tot_hrep_2_loan_intt"><?= $tot_hrep_2_loan_intt ?></span></td>
                                                                <td><span id="tot_p_tax"><?= $tot_p_tax ?></span></td>
                                                                <td><span id="tot_assn"><?= $tot_assn ?></span></td>
                                                                <td><span id="tot_ex_adj"><?= $tot_ex_adj ?></span></td>
                                                                <td><span id="tot_mr_loan_1_prn"><?= $tot_mr_loan_1_prn ?></span></td>
                                                                <td><span id="tot_mr_loan_1_intt"><?= $tot_mr_loan_1_intt ?></span></td>
                                                                <td><span id="tot_mr_loan_2_prn"><?= $tot_mr_loan_2_prn ?></span></td>
                                                                <td><span id="tot_mr_loan_2_intt"><?= $tot_mr_loan_2_intt ?></span></td>
                                                                <td><span id="tot_med_loan_prn"><?= $tot_med_loan_prn ?></span></td>
                                                                <td><span id="tot_med_loan_intt"><?= $tot_med_loan_intt ?></span></td>
                                                                <td><span id="tot_spl_med_loan_prn"><?= $tot_spl_med_loan_prn ?></span></td>
                                                                <td><span id="tot_spl_med_loan_intt"><?= $tot_spl_med_loan_intt ?></span></td>
                                                                <td><span id="tot_tot_diduction"><?= $tot_tot_diduction ?></span></td>
                                                                <td style="display: none;"><span id="tot_net_sal"><?= $tot_net_sal ?></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="sal_date" value="<?= $selected['sal_date']; ?>">
                                        <input type="hidden" name="catg_id" value="<?= $selected['catg_id']; ?>">
                                        <input type="hidden" name="flag" value="<?= $selected['sal_flag']; ?>">
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary mr-2" <?= $disabled ?>>Submit</button>
                                            <a href="<?= site_url() ?>/slryded" class="btn btn-light">Back</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php } ?>
    </div>

    <script>
        $('#sal_date').on('change', function() {
            var sal_date = $(this).val()
            var catg_id = $('#catg_id').val()
            if (catg_id > 0) {
                $.ajax({
                    type: "GET",
                    url: "<?= site_url() ?>/salary/chk_deduction",
                    data: {
                        "sal_date": sal_date,
                        "catg_id": catg_id
                    },
                    dataType: 'html',
                    success: function(result) {
                        if (result) {
                            alert("You have already entered this month's deduction");
                            $('#submit').attr('disabled', 'disabled')
                        } else {
                            $('#submit').removeAttr('disabled')
                        }
                    }
                });
            }
        })
        $('#catg_id').on('change', function() {
            var catg_id = $(this).val()
            var sal_date = $('#sal_date').val()
            $.ajax({
                type: "GET",
                url: "<?= site_url() ?>/salary/chk_deduction",
                data: {
                    "sal_date": sal_date,
                    "catg_id": catg_id
                },
                dataType: 'html',
                success: function(result) {
                    if (result) {
                        alert("You have already entered this month's deduction");
                        $('#submit').attr('disabled', 'disabled')
                    } else {
                        $('#submit').removeAttr('disabled')
                    }
                }
            });
        })
    </script>

    <script>
        function cal_deduction(id) {
            var gross = $('#gross_' + id).val() > 0 ? $('#gross_' + id).val() : 0;
            var tds = $('#tds_' + id).val() > 0 ? $('#tds_' + id).val() : 0;
            var pf = $('#pf_' + id).val() > 0 ? $('#pf_' + id).val() : 0;
            var giss = $('#giss_' + id).val() > 0 ? $('#giss_' + id).val() : 0;
            var sss = $('#sss_' + id).val() > 0 ? $('#sss_' + id).val() : 0;
            var fes_adv = $('#fes_adv_' + id).val() > 0 ? $('#fes_adv_' + id).val() : 0;
            var gsli = $('#gsli_' + id).val() > 0 ? $('#gsli_' + id).val() : 0;
            var hr = $('#hr_' + id).val() > 0 ? $('#hr_' + id).val() : 0;
            var od = $('#od_' + id).val() > 0 ? $('#od_' + id).val() : 0;
            var dms_loan_prn = $('#dms_loan_prn_' + id).val() > 0 ? $('#dms_loan_prn_' + id).val() : 0;
            var dms_loan_intt = $('#dms_loan_intt_' + id).val() > 0 ? $('#dms_loan_intt_' + id).val() : 0;
            var hrep_1_loan_pr = $('#hrep_1_loan_pr_' + id).val() > 0 ? $('#hrep_1_loan_pr_' + id).val() : 0;
            var hrep_1_loan_intt = $('#hrep_1_loan_intt_' + id).val() > 0 ? $('#hrep_1_loan_intt_' + id).val() : 0;
            var hrep_2_loan_pr = $('#hrep_2_loan_pr_' + id).val() > 0 ? $('#hrep_2_loan_pr_' + id).val() : 0;
            var hrep_2_loan_intt = $('#hrep_2_loan_intt_' + id).val() > 0 ? $('#hrep_2_loan_intt_' + id).val() : 0;
            var p_tax = $('#p_tax_' + id).val() > 0 ? $('#p_tax_' + id).val() : 0;
            var assn = $('#assn_' + id).val() > 0 ? $('#assn_' + id).val() : 0;
            var ex_adj = $('#ex_adj_' + id).val() > 0 ? $('#ex_adj_' + id).val() : 0;
            var mr_loan_1_prn = $('#mr_loan_1_prn_' + id).val() > 0 ? $('#mr_loan_1_prn_' + id).val() : 0;
            var mr_loan_1_intt = $('#mr_loan_1_intt_' + id).val() > 0 ? $('#mr_loan_1_intt_' + id).val() : 0;
            var mr_loan_2_prn = $('#mr_loan_2_prn_' + id).val() > 0 ? $('#mr_loan_2_prn_' + id).val() : 0;
            var mr_loan_2_intt = $('#mr_loan_2_intt_' + id).val() > 0 ? $('#mr_loan_2_intt_' + id).val() : 0;
            var med_loan_prn = $('#med_loan_prn_' + id).val() > 0 ? $('#med_loan_prn_' + id).val() : 0;
            var med_loan_intt = $('#med_loan_intt_' + id).val() > 0 ? $('#med_loan_intt_' + id).val() : 0;
            var spl_med_loan_prn = $('#spl_med_loan_prn_' + id).val() > 0 ? $('#spl_med_loan_prn_' + id).val() : 0;
            var spl_med_loan_intt = $('#spl_med_loan_intt_' + id).val() > 0 ? $('#spl_med_loan_intt_' + id).val() : 0;
            
            var tot_diduction = $('#tot_diduction_' + id).val();
            var net_sal = $('#net_sal_' + id).val();
            var total_did = parseInt(tds) + parseInt(pf) + parseInt(giss) + parseInt(sss) + parseInt(fes_adv) + parseInt(gsli) + parseInt(hr) + parseInt(od) + parseInt(dms_loan_prn) + parseInt(dms_loan_intt) + parseInt(hrep_1_loan_pr) + parseInt(hrep_1_loan_intt) + parseInt(hrep_2_loan_pr) + parseInt(hrep_2_loan_intt) + parseInt(p_tax) + parseInt(assn) + parseInt(ex_adj) + parseInt(mr_loan_1_prn) + parseInt(mr_loan_1_intt) + parseInt(mr_loan_2_prn) + parseInt(mr_loan_2_intt) + parseInt(med_loan_prn) + parseInt(med_loan_intt) + parseInt(spl_med_loan_prn) + parseInt(spl_med_loan_intt)

            // var tot_gross_int = parseInt(gpf) + parseInt(lpf) + parseInt(gi)
            // $('#top_' + id).val(tot_gross_int)

            $('#tot_diduction_' + id).val(total_did)

            var diduction = parseInt(gross) - parseInt(total_did)
            $('#net_sal_' + id).val(diduction);
            cal_tot_amt();
        }

        function cal_tot_amt() {
            var tot_tds = 0,
            tot_pf = 0,
            tot_giss = 0,
            tot_sss = 0,
            tot_fes_adv = 0,
            tot_gsli = 0,
            tot_hr = 0,
            tot_od = 0,
            tot_dms_loan_prn = 0,
            tot_dms_loan_intt = 0,
            tot_hrep_1_loan_pr = 0,
            tot_hrep_1_loan_intt = 0,
            hrep_2_loan_pr = 0,
            hrep_2_loan_intt = 0,
            p_tax = 0,
            assn = 0,
            ex_adj = 0,
            mr_loan_1_prn = 0,
            mr_loan_1_intt = 0,
            mr_loan_2_prn = 0,
            mr_loan_2_intt = 0,
            med_loan_prn = 0,
            med_loan_intt = 0,
            spl_med_loan_prn = 0,
            spl_med_loan_intt = 0,
            tot_tot_diduction = 0,
            tot_net_sal = 0;

            $('input[name="tds[]"]').each(function() {
                tot_tds = parseInt(tot_tds) + parseInt(this.value)
            });
            $('input[name="pf[]"]').each(function() {
                tot_pf = parseInt(tot_pf) + parseInt(this.value)
            });
            $('input[name="pf[]"]').each(function() {
                tot_pf = parseInt(tot_pf) + parseInt(this.value)
            });
            $('input[name="giss[]"]').each(function() {
                tot_giss = parseInt(tot_giss) + parseInt(this.value)
            });
            $('input[name="sss[]"]').each(function() {
                tot_sss = parseInt(tot_sss) + parseInt(this.value)
            });
            $('input[name="fes_adv[]"]').each(function() {
                tot_fes_adv = parseInt(tot_fes_adv) + parseInt(this.value)
            });
            $('input[name="gsli[]"]').each(function() {
                tot_gsli = parseInt(tot_gsli) + parseInt(this.value)
            });
            $('input[name="hr[]"]').each(function() {
                tot_hr = parseInt(tot_hr) + parseInt(this.value)
            });
            $('input[name="od[]"]').each(function() {
                tot_od = parseInt(tot_od) + parseInt(this.value)
            });
            $('input[name="dms_loan_prn[]"]').each(function() {
                tot_dms_loan_prn = parseInt(tot_dms_loan_prn) + parseInt(this.value)
            });
            $('input[name="dms_loan_intt[]"]').each(function() {
                tot_dms_loan_intt = parseInt(tot_dms_loan_intt) + parseInt(this.value)
            });
            $('input[name="hrep_1_loan_pr[]"]').each(function() {
                tot_hrep_1_loan_pr = parseInt(tot_hrep_1_loan_pr) + parseInt(this.value)
            });
            $('input[name="hrep_1_loan_intt[]"]').each(function() {
                tot_hrep_1_loan_intt = parseInt(tot_hrep_1_loan_intt) + parseInt(this.value)
            });
            $('input[name="hrep_2_loan_pr[]"]').each(function() {
                tot_hrep_2_loan_pr = parseInt(tot_hrep_2_loan_pr) + parseInt(this.value)
            });
            $('input[name="hrep_2_loan_intt[]"]').each(function() {
                tot_hrep_2_loan_intt = parseInt(tot_hrep_2_loan_intt) + parseInt(this.value)
            });
            $('input[name="p_tax[]"]').each(function() {
                tot_p_tax = parseInt(tot_p_tax) + parseInt(this.value)
            });
            $('input[name="assn[]"]').each(function() {
                tot_assn = parseInt(tot_assn) + parseInt(this.value)
            });
            $('input[name="ex_adj[]"]').each(function() {
                tot_ex_adj = parseInt(tot_ex_adj) + parseInt(this.value)
            });
            $('input[name="mr_loan_1_prn[]"]').each(function() {
                tot_mr_loan_1_prn = parseInt(tot_mr_loan_1_prn) + parseInt(this.value)
            });
            $('input[name="mr_loan_1_intt[]"]').each(function() {
                tot_mr_loan_1_intt = parseInt(tot_mr_loan_1_intt) + parseInt(this.value)
            });
            $('input[name="mr_loan_2_prn[]"]').each(function() {
                tot_mr_loan_2_prn = parseInt(tot_mr_loan_2_prn) + parseInt(this.value)
            });
            $('input[name="mr_loan_2_intt[]"]').each(function() {
                tot_mr_loan_2_intt = parseInt(tot_mr_loan_2_intt) + parseInt(this.value)
            });
            $('input[name="med_loan_prn[]"]').each(function() {
                tot_med_loan_prn = parseInt(tot_med_loan_prn) + parseInt(this.value)
            });
            $('input[name="med_loan_intt[]"]').each(function() {
                tot_med_loan_intt = parseInt(tot_med_loan_intt) + parseInt(this.value)
            });
            $('input[name="spl_med_loan_prn[]"]').each(function() {
                tot_spl_med_loan_prn = parseInt(tot_spl_med_loan_prn) + parseInt(this.value)
            });
            $('input[name="spl_med_loan_intt[]"]').each(function() {
                tot_spl_med_loan_intt = parseInt(tot_spl_med_loan_intt) + parseInt(this.value)
            });
            
            $('input[name="tot_diduction[]"]').each(function() {
                tot_tot_diduction = parseInt(tot_tot_diduction) + parseInt(this.value)
            });
            $('input[name="net_sal[]"]').each(function() {
                tot_net_sal = parseInt(tot_net_sal) + parseInt(this.value)
            });

            $('#tot_tds').text(tot_tds)
            $('#tot_pf').text(tot_pf)
            $('#tot_giss').text(tot_giss)
            $('#tot_sss').text(tot_sss)
            $('#tot_fes_adv').text(tot_fes_adv)
            $('#tot_gsli').text(tot_gsli)
            $('#tot_hr').text(tot_hr)
            $('#tot_od').text(tot_od)
            $('#tot_dms_loan_prn').text(tot_dms_loan_prn)
            $('#tot_dms_loan_intt').text(tot_dms_loan_intt)
            $('#tot_hrep_1_loan_pr').text(tot_hrep_1_loan_pr)
            $('#tot_hrep_1_loan_intt').text(tot_hrep_1_loan_intt)
            $('#hrep_2_loan_pr').text(hrep_2_loan_pr)
            $('#hrep_2_loan_intt').text(hrep_2_loan_intt)
            $('#p_tax').text(p_tax)
            $('#assn').text(assn)
            $('#ex_adj').text(ex_adj)
            $('#mr_loan_1_prn').text(mr_loan_1_prn)
            $('#mr_loan_1_intt').text(mr_loan_1_intt)
            $('#mr_loan_2_prn').text(mr_loan_2_prn)
            $('#mr_loan_2_intt').text(mr_loan_2_intt)
            $('#med_loan_prn').text(med_loan_prn)
            $('#med_loan_intt').text(med_loan_intt)
            $('#spl_med_loan_prn').text(spl_med_loan_prn)
            $('#spl_med_loan_intt').text(spl_med_loan_intt)
            $('#tot_tot_diduction').text(tot_tot_diduction)
            $('#tot_net_sal').text(tot_net_sal)
        }
    </script>

    <script>
        $(document).ready(function() {
            var catg_id = <?= $selected['catg_id'] ?> > 0 ? <?= $selected['catg_id'] ?> : 0;
            if (catg_id > 0) {
                $('#sal_date').attr('', '')
                <?php if (!isset($_REQUEST['submit'])) { ?>
                    $('#submit').click();
                <?php } ?>
            }
        })
    </script>