<style>
    .table td .form-group {
        width: 165px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper content_wrapper_custom">
        <div class="card">
            <div class="card-body">
                <h3>Add Earnings</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("slryad"); ?>?catg_id=<?= $selected['catg_id'] ?>&sys_dt=<?= $selected['sal_date'] ?>&flag=<?= $selected['sal_flag'] ?>">
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
                    <h3>Add Earnings</h3>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body card_bodyCustom">
                                    <form method="POST" id="form" action="<?php echo site_url("salsv"); ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive" id='permanent'>

                                                    <table class="table">
                                                        <thead class="fixedHeaderTable">
                                                            <tr>
                                                                <th>Emp name</th>
                                                                <th>Basic</th>
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
                                                                <th>Gross Salary</th>
                                                                <th>LWP</th>
                                                                <th>GROSS SALARY (after deduction)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $tot_final_gross = 0;
                                                            $tot_basic = 0;
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
                                                            $tot_gross = 0;
                                                            $tot_lwp = 0;
                                                            if ($sal_list) {
                                                                $i = 0;
                                                                foreach ($sal_list as $sal) {
                                                                    $tot_final_gross += $sal['final_gross'];
                                                                    $tot_basic += $sal['basic'];
                                                                    $tot_da += $sal['da'];
                                                                    $tot_hra += $sal['hra'];
                                                                    $tot_ma += $sal['ma'];
                                                                    $tot_ca += $sal['ca'];
                                                                    $tot_ip += $sal['ip'];
                                                                    $tot_fa += $sal['fa'];
                                                                    $tot_dep += $sal['dep'];
                                                                    $tot_oa += $sal['oa'];
                                                                    $tot_bonus += $sal['bonus'];
                                                                    $tot_exp += $sal['exp'];
                                                                    $tot_ada += $sal['ada'];
                                                                    $tot_gross += $sal['gross'];
                                                                    $tot_lwp += $sal['lwp'];
                                                            ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="emp_name[]" class="form-control required" id="emp_name_<?= $i ?>" value="<?= $sal['emp_name']; ?>" readonly />
                                                                                <input type="hidden" name="emp_code[]" id="emp_code_<?= $i ?>" value="<?= $sal['emp_code'] ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="basic[]" class="form-control required" id="basic_<?= $i ?>" value="<?= $sal['basic']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="da[]" class="form-control required" id="da_<?= $i ?>" value="<?= $sal['da']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="hra[]" class="form-control required" id="hra_<?= $i ?>" value="<?= $sal['hra']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ma[]" class="form-control required" id="ma_<?= $i ?>" value="<?= $sal['ma']; ?>"  />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ca[]" class="form-control required" id="ca_<?= $i ?>" value="<?= $sal['ca']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ip[]" class="form-control required" id="ip_<?= $i ?>" value="<?= $sal['ip']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="fa[]" class="form-control required" id="fa_<?= $i ?>" value="<?= $sal['fa']; ?>" onchange="calculate_bal(<?= $i ?>)"/>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="dep[]" class="form-control required" id="dep_<?= $i ?>" value="<?= $sal['dep']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="oa[]" class="form-control required" id="oa_<?= $i ?>" value="<?= $sal['oa']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="bonus[]" class="form-control required" id="bonus_<?= $i ?>" value="<?= $sal['bonus']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="exp[]" class="form-control required" id="exp_<?= $i ?>" value="<?= $sal['exp']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ada[]" class="form-control required" id="ada_<?= $i ?>" value="<?= $sal['ada']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="gross[]" class="form-control required" id="gross_<?= $i ?>" value="<?= $sal['gross']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="lwp[]" class="form-control required" id="lwp_<?= $i ?>" value="<?= $sal['lwp']; ?>" onchange="lwp_cal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="final_gross[]" class="form-control required" id="final_gross_<?= $i ?>" value="<?= $sal['final_gross']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                            <?php $i++;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td>Total:</td>
                                                                <td><span id="tot_basic"><?= $tot_basic ?></span></td>
                                                                <td><span id="tot_da"><?= $tot_da ?></span></td>
                                                                <td><span id="tot_hra"><?= $tot_hra ?></span></td>
                                                                <td><span id="tot_ma"><?= $tot_ma ?></span></td>
                                                                <td><span id="tot_ca"><?= $tot_ca ?></span></td>
                                                                <td><span id="tot_ip"><?= $tot_ip ?></span></td>
                                                                <td><span id="tot_fa"><?= $tot_fa ?></span></td>
                                                                <td><span id="tot_dep"><?= $tot_dep ?></span></td>
                                                                <td><span id="tot_oa"><?= $tot_oa ?></span></td>
                                                                <td><span id="tot_bonus"><?= $tot_bonus ?></span></td>
                                                                <td><span id="tot_exp"><?= $tot_exp ?></span></td>
                                                                <td><span id="tot_ada"><?= $tot_ada ?></span></td>
                                                                <td><span id="tot_gross"><?= $tot_gross ?></span></td>
                                                                <td><span id="tot_lwp"><?= $tot_lwp ?></span></td>
                                                                <td><span id="tot_final_gross"><?= $tot_final_gross ?></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <label class="mt-3"><b>Total Gross Salary (After Deduction): </b>&#8377 <span id="tot_gross_show"><?= $tot_gross ?></span>/-</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="sal_date" value="<?= $selected['sal_date']; ?>">
                                        <input type="hidden" name="catg_id" value="<?= $selected['catg_id']; ?>">
                                        <input type="hidden" name="flag" value="<?= $selected['sal_flag']; ?>">
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <a href="<?= site_url() ?>/slrydtl" class="btn btn-light">Back</a>
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
                    url: "<?= site_url() ?>/salary/chk_sal",
                    data: {
                        "sal_date": sal_date,
                        "catg_id": catg_id
                    },
                    dataType: 'html',
                    success: function(result) {
                        if (result) {
                            alert("You have already entered this month's earning");
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
                url: "<?= site_url() ?>/salary/chk_sal",
                data: {
                    "sal_date": sal_date,
                    "catg_id": catg_id
                },
                dataType: 'html',
                success: function(result) {
                    if (result) {
                        alert("You have already entered this month's earning");
                        $('#submit').attr('disabled', 'disabled')
                    } else {
                        $('#submit').removeAttr('disabled')
                    }
                }
            });
        })
    </script>

    <script>
        function calculate_bal(id) {
            var basic = $('#basic_'+id).val() > 0 ? $('#basic_'+id).val() : 0,
            da = $('#da_'+id).val() > 0 ? $('#da_'+id).val() : 0,
            hra = $('#hra_'+id).val() > 0 ? $('#hra_'+id).val() : 0,
            ma = $('#ma_'+id).val() > 0 ? $('#ma_'+id).val() : 0,
            ca = $('#ca_'+id).val() > 0 ? $('#ca_'+id).val() : 0,
            ip = $('#ip_'+id).val() > 0 ? $('#ip_'+id).val() : 0,
            fa = $('#fa_'+id).val() > 0 ? $('#fa_'+id).val() : 0,
            dep = $('#dep_'+id).val() > 0 ? $('#dep_'+id).val() : 0,
            oa = $('#oa_'+id).val() > 0 ? $('#oa_'+id).val() : 0,
            bonus = $('#bonus_'+id).val() > 0 ? $('#bonus_'+id).val() : 0,
            exp = $('#exp_'+id).val() > 0 ? $('#exp_'+id).val() : 0,
            ada = $('#ada_'+id).val() > 0 ? $('#ada_'+id).val() : 0,
            lwp = $('#lwp_'+id).val() > 0 ? $('#lwp_'+id).val() : 0,
            gross = $('#gross_'+id).val();

            console.log(parseInt(basic), parseInt(da), parseInt(hra), parseInt(ma), parseInt(ca), parseInt(ip), parseInt(fa), parseInt(dep), parseInt(oa), parseInt(bonus), parseInt(exp), parseInt(ada));

            tot_gross = parseInt(basic) + parseInt(da) + parseInt(hra) + parseInt(ma) + parseInt(ca) + parseInt(ip) + parseInt(fa) + parseInt(dep) + parseInt(oa) + parseInt(bonus) + parseInt(exp) + parseInt(ada)
            tot_gross_after_did = parseInt(tot_gross) - parseInt(lwp)

            $('#gross_'+id).val(tot_gross)
            $('#final_gross_'+id).val(tot_gross_after_did)
            cal_tot_amt()
        }

        function cal_tot_amt(){
            var tot_basic = 0,
            tot_da = 0,
            tot_hra = 0,
            tot_ma = 0,
            tot_ca = 0,
            tot_ip = 0,
            tot_fa = 0,
            tot_dep = 0,
            tot_oa = 0,
            tot_bonus = 0,
            tot_exp = 0,
            tot_ada = 0,
            tot_lwp = 0,
            tot_gross = 0;
            
            $('input[name="basic[]"]').each(function() {
                tot_basic = parseInt(tot_basic) + parseInt(this.value)
            });
            $('input[name="da[]"]').each(function() {
                tot_da = parseInt(tot_da) + parseInt(this.value)
            });
            $('input[name="hra[]"]').each(function() {
                tot_hra = parseInt(tot_hra) + parseInt(this.value)
            });
            $('input[name="ma[]"]').each(function() {
                tot_ma = parseInt(tot_ma) + parseInt(this.value)
            });
            $('input[name="ca[]"]').each(function() {
                tot_ca = parseInt(tot_ca) + parseInt(this.value)
            });
            $('input[name="ip[]"]').each(function() {
                tot_ip = parseInt(tot_ip) + parseInt(this.value)
            });
            $('input[name="fa[]"]').each(function() {
                tot_fa = parseInt(tot_fa) + parseInt(this.value)
            });
            $('input[name="dep[]"]').each(function() {
                tot_dep = parseInt(tot_dep) + parseInt(this.value)
            });
            $('input[name="oa[]"]').each(function() {
                tot_oa = parseInt(tot_oa) + parseInt(this.value)
            });
            $('input[name="bonus[]"]').each(function() {
                tot_bonus = parseInt(tot_bonus) + parseInt(this.value)
            });
            $('input[name="exp[]"]').each(function() {
                tot_exp = parseInt(tot_exp) + parseInt(this.value)
            });
            $('input[name="ada[]"]').each(function() {
                tot_ada = parseInt(tot_ada) + parseInt(this.value)
            });
            $('input[name="lwp[]"]').each(function() {
                tot_lwp = parseInt(tot_lwp) + parseInt(this.value)
            });
            $('input[name="gross[]"]').each(function() {
                tot_gross = parseInt(tot_gross) + parseInt(this.value)
            });

            $('#tot_basic').text(tot_basic)
            $('#tot_da').text(tot_da)
            $('#tot_hra').text(tot_hra)
            $('#tot_ma').text(tot_ma)
            $('#tot_ca').text(tot_ca)
            $('#tot_ip').text(tot_ip)
            $('#tot_fa').text(tot_fa)
            $('#tot_dep').text(tot_dep)
            $('#tot_oa').text(tot_oa)
            $('#tot_bonus').text(tot_bonus)
            $('#tot_exp').text(tot_exp)
            $('#tot_ada').text(tot_ada)
            $('#tot_gross').text(tot_gross)
            $('#tot_lwp').text(tot_lwp)
            $('#tot_final_gross').text(parseInt(tot_gross)-parseInt(tot_lwp))

            $('#tot_gross_show').text($('#tot_final_gross').text())
        }
        function cash_cal(id) {
            var cash_val = $('#cash_swa_' + id).val();
            var gross_val = $('#gross_' + id).val();
            var gross = $('#final_gross_' + id).val();
            $('#gross_' + id).val(parseInt(cash_val) + parseInt(gross_val))
            $('#final_gross_' + id).val(parseInt(cash_val) + parseInt(gross))
            var final_gross = 0;
            $('input[name="final_gross[]"]').each(function() {
                final_gross = parseInt(final_gross) + parseInt(this.value);
            })
            $('#tot_final_gross').text(final_gross)
            var tot_cash_swa = 0;
            $('input[name="cash_swa[]"]').each(function() {
                tot_cash_swa = parseInt(tot_cash_swa) + parseInt(this.value);
            })
            $('#tot_cash_swa').text(tot_cash_swa)
			
			var tot_gross = 0
			$('input[name="gross[]"]').each(function() {
                tot_gross = parseInt(tot_gross) + parseInt(this.value);
            })
			$('#tot_gross').text(tot_gross);

            // console.log(final_gross);
        }

        function lwp_cal(id) {
            var lwp_val = $('#lwp_' + id).val();
            //var final_gross = $('#final_gross_' + id).val();
			var gross = $('#gross_' + id).val();
            $('#final_gross_' + id).val(parseInt(gross) - parseInt(lwp_val))
            var final_gross = 0;
            $('input[name="final_gross[]"]').each(function() {
                final_gross = parseInt(final_gross) + parseInt(this.value);
            })
            $('#tot_final_gross').text(final_gross)
            var tot_lwp = 0;
            $('input[name="lwp[]"]').each(function() {
                tot_lwp = parseInt(tot_lwp) + parseInt(this.value);
            })
            $('#tot_lwp').text(tot_lwp)
	    //$('#tot_final_gross').text(final_gross - tot_lwp)
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