<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3>Employee Category Edit</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="myform" action="<?php echo site_url("scatg"); ?>">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Category:</label>
                                                <input type="text" class="form-control" name="category" id="category" value="<?php echo $selected['category']; ?>" />
                                            </div>
                                            <div class="col-6">
                                                <label for="da1">D.A. 1 (%):</label>
                                                <input type="text" class="form-control" name="da1" id="da1" value="<?php echo $selected['da1']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="da2">D.A. 2 (%):</label>
                                                <input type="text" class="form-control" name="da2" id="da2" value="<?php echo $selected['da2']; ?>" />
                                            </div>
                                            <div class="col-6">
                                                <label for="basic_max">Max Basic:</label>
                                                <input type="text" class="form-control" name="basic_max" id="basic_max" value="<?php echo $selected['basic_max']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="hra">H.R.A.(%):</label>
                                                <input type="text" class="form-control" name="hra" id="hra" value="<?php echo $selected['hra']; ?>" />
                                            </div>
                                            <div class="col-6">
                                                <label for="ma">M.A.:</label>
                                                <input type="text" class="form-control required" name="ma" id="ma" value="<?php echo $selected['ma']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="pf">P.F.(%):</label>
                                                <input type="text" class="form-control" name="pf" id="pf" value="<?php echo $selected['pf']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?= $selected['id'] ?>">
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>