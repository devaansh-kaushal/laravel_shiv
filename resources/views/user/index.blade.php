<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Index Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div class="container">
        <!-- form body -->
        <div class="row">
            <div class="col-md-12">
                <form id="InputForm" action="#">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="hidden" name="userId" id="userId">
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" onkeyup="validateEmail()">
                    </div>
                    <input type="submit" name="save" class="btn btn-info" value="Save">
                    <button class="btn btn-warning" onclick="resetForm()">Cancel</button>                        

                </form>
            </div>
        </div>
        <!-- form body -->

        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                    if(isset($userList) && !empty($userList)){
                        $i = 1;
                        foreach ($userList as $key => $value) {
                            ?>   
                            <tr>
                                <th scope="row"><?=$i?></th>
                                <td><?=(isset($value->name) && !empty($value->name) ? $value->name : '')?></td>
                                <td><?=(isset($value->email) && !empty($value->email) ? $value->email : '')?></td>
                                <td>
                                    <button class="btn btn-danger" onclick="onDelete('<?= $value->id ?>')">Delete</button>
                                    <button class="btn btn-danger" onclick="onGetData('<?= $value->id ?>')">Update</button>
                                </td>
                            </tr>  
                            <?php
                            $i++;
                        }                    
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        function resetForm()
        {
            document.getElementById('InputForm').reset();
            return false;
        }

        function onGetData(paramId){
            return false;
        }

        function validateEmail() {
            const emailInput = document.getElementById('email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var returnResult = emailRegex.test(emailInput);

            console.log('returnResult == ',returnResult);

            return false;
        }

        function onDelete(paramuserId){
          $.ajax({
            type: 'post',
            url: '<?= url('')."/delete" ?>',
            data: {userId:paramuserId,_token: $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function(response) {
                var status = response.status;
                var message = response.message;
                if(status == "000"){
                    // document.getElementById('InputForm').reset(); 
                    window.location.reload();
                }
                else {
                    alert(message);
                    return false;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error submitting form');
                console.error(xhr.responseText);
            }
        });
          return false;
      }



      $('#InputForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        var formData = $(this).serialize();
        var name = document.getElementById('username').value.trim();
        var email = document.getElementById('email').value.trim();

        if (name === '' || email === '') {
            alert('Please fill in all required fields.');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?= url('')."/save" ?>',
            data: formData,
            dataType: "json",
            success: function(response) {
                var status = response.status;
                var message = response.message;
                if(status == "000"){
                    document.getElementById('InputForm').reset();
                    window.location.reload();
                }
                else {
                    alert(message);
                    return false;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error submitting form');
                console.error(xhr.responseText);
            }
        });
        return false;
    });



</script>
</body>
</html>