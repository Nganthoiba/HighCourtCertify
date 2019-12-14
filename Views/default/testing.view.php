<h2>Cards with Contextual Classes</h2>
  <div class="card">
    <div class="card-body">Basic card</div>
  </div>
  <br>
  <div class="card bg-primary text-white">
    <div class="card-body">Primary card</div>
  </div>
  <br>
  <div class="card bg-success text-white">
    <div class="card-body">Success card</div>
  </div>
  <br>
  <div class="card bg-info text-white">
    <div class="card-body">Info card</div>
  </div>
  <br>
  <div class="card bg-warning text-white">
    <div class="card-body">Warning card</div>
  </div>
  <br>
  <div class="card bg-danger text-white">
    <div class="card-body">Danger card</div>
  </div>
  <br>
  <div class="card bg-secondary text-white">
    <div class="card-body">Secondary card</div>
  </div>
  <br>
  <div class="card bg-dark text-white">
    <div class="card-body">Dark card</div>
  </div>
  <br>
  <div class="card bg-light text-dark">
    <div class="card-body">Light card</div>
  </div>
  
  <h2>Simple Collapsible</h2>
  <p>Click on the button to toggle between showing and hiding content.</p>
  <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo">Simple collapsible</button>
  <div id="demo" class="collapse">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
  </div>
  
  <h2>Custom Checkbox</h2>
  <p>To create a custom checkbox, wrap a container element, like div, with a class of .custom-control and .custom-checkbox around the checkbox. Then add the .custom-control-input to the checkbox.</p>
  <p><strong>Tip:</strong> If you use labels for accompanying text, add the .custom-control-label class to it. Note that the value of the for attribute should match the id of the checkbox:</p>
  <form action="/action_page.php">
    <div class="custom-control custom-checkbox mb-3">
      <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
      <label class="custom-control-label" for="customCheck">Custom checkbox</label>
    </div>
    <input type="checkbox" id="defaultCheck" name="example2">
    <label for="defaultCheck">Default checkbox</label>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  
  <div class="container">
  <h3>Toast Example</h3>
  <p>A toast is like an alert box that is only shown for a couple of seconds when something happens (i.e. when a user clicks on a button, submits a form, etc.).</p>
  <p>In this example, we use a button to show the toast message.</p>
 
  <button type="button" class="btn btn-primary" id="myBtn">Show Toast</button>

  <div class="toast">
    <div class="toast-header">
      Toast Header
    </div>
    <div class="toast-body">
      Some text inside the toast body
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $("#myBtn").click(function(){
    $('.toast').toast('show');
  });
});
</script>

<h2>Basic Table</h2>
  <p>The .table class adds basic styling (light padding and horizontal dividers) to a table:</p>            
  <table class="table">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table>