<div class="container">
    <!--Naked Form-->
    <form name="feedback_form">
        <div class="card-block">

            <!--Header-->
            <div class="text-center">
                <h3><i class="fa fa-envelope"></i> Please do write to us:</h3>
                <hr class="mt-2 mb-2">
            </div>

            <!--Body-->
            <p>We'll write rarely, but only the best content.</p>

            <!--Body-->
            <div class="md-form">
                <i class="fa fa-user prefix"></i>
                <input type="text" id="form3" name="user_name"class="form-control">
                <label for="form3">Your name</label>
            </div>

            <div class="md-form">
                <i class="fa fa-envelope prefix"></i>
                <input type="text" id="form2" name="email" class="form-control">
                <label for="form2">Your email</label>
            </div>

            <div class="md-form">
                <i class="fa fa-tag prefix"></i>
                <input type="text" id="form32" name="subject" class="form-control">
                <label for="form34">Subject</label>
            </div>

            <div class="md-form">
                <i class="fa fa-pencil prefix"></i>
                <textarea type="text" id="form8" name="contents" class="md-textarea"></textarea>
                <label for="form8">Say something!</label>
            </div>

<!--            <div class="md-form">
                <input type="checkbox" name="fruits[]" value="Mango"/>Mango<br/>
                <input type="checkbox" name="fruits[]" value="Banana"/>Banana<br/>
                <input type="checkbox" name="fruits[]" value="Papaya"/>Papaya<br/>
                <input type="checkbox" name="fruits[]" value="Orange"/>Orange<br/>

                <input type="radio" name="myradio" value="myradio1"/>myradio1<br/>
                <input type="radio" name="myradio" value="myradio2"/>myradio2<br/>
                <input type="radio" name="myradio" value="myradio3"/>myradio3<br/>

                <input type="checkbox" name="tools[]" value="Pen"/>Pen<br/>
                <input type="checkbox" name="tools[]" value="Pencils"/>Pencils<br/>
                
                <input type="checkbox" name="fruits[]" value="Lemon"/>Lemon<br/>
                
                <input type="radio" name="devices" value="laptop"/>laptop<br/>
                <input type="radio" name="devices" value="printer"/>printer<br/>
                <input type="radio" name="devices" value="tv"/>tv<br/>

                <input type="checkbox" name="flowers[]" value="Sunflower"/>Sunflower<br/>
                <input type="checkbox" name="flowers[]" value="China Rose"/>China Rose<br/>
                <input type="checkbox" name="flowers[]" value="Marigold"/>Marigold<br/>
                

                <input type="text" name="friends[]" />Friend<br/>
                <input type="text" name="students[]" />students<br/>
                <input type="text" name="students[]" />students<br/>
                <input type="text" name="students[]" />students<br/>
                <input type="text" name="friends[]" />Friend<br/>
                <input type="text" name="friends[]" />Friend<br/>
                <input type="text" name="students[]" />students<br/>
                <input type="text" name="students[]" />students<br/>
                <input type="text" name="students[]" />students<br/>
                <input type="text" name="friends" />Friend<br/>
                
                <input type="checkbox" name="confirmed" value="Yes"/>Confirm<br/>
            </div>-->
            <div class="text-center">
                <button type="submit" class="btn btn-default">Submit</button>

                <div class="call">
                    <p>Or would you prefer to call?
                        <br>
                        <span><i class="fa fa-mobile-phone"> </i></span> + 91 9089517468</p>
                </div>
            </div>
        </div>
                
    </form>
    <div id="result"></div>
    <!--Naked Form-->
</div>
<script type="text/javascript">
    var feedback_form = document.forms['feedback_form'];
    feedback_form.onsubmit = function(event){
        event.preventDefault();
        var data = getFormDataAsJson(feedback_form);
        document.getElementById("result").innerHTML = JSON.stringify(data);
    };
</script>