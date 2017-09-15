<?php
require_once "../layout/header.php";
require_once "../layout/checkSession.php";
?>
<div style="width:90%;margin: 0 auto;background-color:#f7f9fa;padding:20px">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#contactTab" data-toggle="tab" aria-expanded="true">Contact Data</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="contactTab">
            <br/>
            <form class="">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Name:</label>
                            <input type="email" class="form-control" id="email">
                        </div>


                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pwd">Phone Number:</label>
                            <input type="password" class="form-control" id="pwd">
                        </div>


                    </div>

                    <div class="col-md-4">


                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="pwd"></label>
                            <a href="#" class="btn btn-primary form-control" data-toggle="modal" data-target="#addNewContactModal">Add New Contact</a>
                        </div>

                    </div>
                </div>

            </form>

            <div id="detailedTable">
                <table class="table table-bordered table-hover ">
                    <thead>
                    <tr>
                        <th style="background-color: lightblue">ID</th>
                        <th style="background-color: lightblue">Name</th>
                        <th style="background-color: lightblue">Email</th>
                        <th style="background-color: lightblue">Mobile No</th>
                        <th style="background-color: lightblue">Landline No</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr class="info">
                        <td>3</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr class="success">
                        <td>4</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr class="danger">
                        <td>5</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr class="warning">
                        <td>6</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    <tr class="active">
                        <td>7</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                        <td>Column content</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" role="dialog" id="addNewContactModal">
    <div class="modal-dialog" style="width:55%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>One fine body…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php

require_once "../layout/footer.php";
?>
<script>


</script>
