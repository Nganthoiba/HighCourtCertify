        <div class="container">
            <form name="view_status_form" method="POST" action="#">
                <div class="row">
                    <div class="col-sm-4 mx-auto">
                        <p>Please enter your AADHAAR number which was used while submitting your form of application for copy</p>
                        <div class="md-form mb-0">
                            <input style="font-size: 18pt; text-align: center" type="text" name="aadhaar_id" 
                                   id="aadhaar_id" class="form-control"/>
                            <label for="aadhaar_id">Your AADHAAR ID:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mx-auto">
                        <center>
                            <button id="submitApplicationID" type="button" class="btn btn-cyan">Submit</button>
                        </center>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#aadhaar_id").inputmask({"mask": "9999 9999 9999"});
            });
        </script>

