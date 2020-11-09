  <!-- styles -->
  <link rel="stylesheet" href="http://intern-affiliate.smtapps.net/material/css/material-dashboard.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="http://intern-affiliate.smtapps.net/mystyle.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.css">
<link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />


  <!--  container  -->
   <!-- start -->
  <form action="aasdsadsadsa" method="post">
      <div class="card card-login card-hidden container" style="max-width: 825px">
          <div class="card-header card-header-primary text-center pb-4 pt-4">
              <h4 class="card-title"><strong>Register</strong></h4>
          </div>
          <div class="card-body mt-3">
              <div class="row">
                  <div class="col-6">
                      <div class="form-group ">
                          <label for="name">Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control pt-3" id="name" placeholder="Full Name" name="name"
                              value="">
                      </div>
                      <div class="form-group mt-2">
                          <label for="email">Email Address <span class="text-danger">*</span></label>
                          <input type="text" class="form-control pt-3" id="email" placeholder="email@example.com"
                              name="email" value="">
                      </div>
                      <div class="form-group mt-2">
                          <label for="phone">Phone Number</label>
                          <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                              class="form-control pt-3" id="phone" placeholder="08xx-xxxx-xxxxx" name="phone" value="">

                      </div>
                      <div class="form-group mt-2">
                          <label for="country">Country <span class="text-danger">*</span></label>
                          <select class="form-control" data-style="btn btn-link" id="country" name="country">
                              <option selected value="indonesia">indonesia</option>
                          </select>

                      </div>
                      <div class="row ml-1">
                          <div class="col-lg-6 col-sm-12" style="margin-left: -1rem">
                              <div class="form-group mt-2">
                                  <label for="state">State/Province <span class="text-danger">*</span></label>
                                  <select class="form-control" data-style="btn btn-link" id="province" name="state"
                                      value="">
                                      <option value="" selected disabled>Select your province</option>

                                  </select>

                              </div>
                          </div>
                          <div class="col-lg-6 col-sm-12">
                              <div class="form-group">
                                  <label for="city">City <span class="text-danger">*</span></label>
                                  <select class="form-control" data-style="btn btn-link" id="city" name="city" value="">
                                      <option value="" selected disabled>Select your city</option>
                                  </select>

                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-6">
                      <div class="form-group mt-2">
                          <label for="address">Address <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="address" " placeholder=" Your Address"
                              name="address">

                      </div>
                      <div class="form-group mt-2">
                          <label for="Category_Product">Category Product <span class="text-danger">*</span></label>
                          <select class="form-control custom-select" data-style="btn btn-link" id="Category_Product"
                              name="product_id">
                              <option value="" selected disabled>Select Product</option>

                          </select>

                      </div>
                      <div class="form-group mt-2">
                          <label for="password">Password <span class="text-danger">*</span></label>
                          <input type="password" class="form-control pt-3" id="password" placeholder="Your Password"
                              name="password">
                          <span class="form-check-sign-register" id="check">
                              <i class="material-icons password-icon text-secondary" aria-hidden="true"
                                  id="icon-pass">remove_red_eye</i>
                          </span>
                          <small class="text-danger" id="hint">Password must be contain 8 character, uppercase
                              and lowercase letter, number and special character. Ex: Password23!</small>

                      </div>
                      <div class="form-group mt-3">
                          <label for="password">Password Confirmation <span class="text-danger">*</span></label>
                          <input type="password" class="form-control pt-3" id="password_confirmation"
                              placeholder="Re Password" name="password_confirmation">
                          <span class="form-check-sign-register" id="check2">
                              <i class="material-icons password-icon text-secondary" aria-hidden="true"
                                  id="icon-pass2">remove_red_eye</i>
                          </span>
                          <span id="confirm-message2" class="confirm-message"></span>
                      </div>
                  </div>
                  <div class="form-check mt-4 ml-auto mr-auto">
                      <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" id="policy" name="policy">
                          <span class="form-check-sign">
                              <span class="check"></span>
                          </span>
                          I agree with the
                      </label>
                      <a href="#" data-toggle="modal" data-target="#policyModal">Privacy Policy</a>

                  </div>
              </div>
          </div>
          <div class="card-footer justify-content-center">
              <button type="submit" class="btn btn-primary btn-link btn-lg">Create account</button>
          </div>
      </div>
  </form>
  <!-- end  -->


  <!-- Modal -->
  <div class="modal fade" id="policyModal" tabindex="-1" role="dialog" aria-labelledby="policyModalTitle"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title text-dark" id="policyModalTitle">Privacy and Policy</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span class="material-icons">
                          close
                      </span>
                  </button>
              </div>
              <div class="modal-body text-secondary">
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab iusto illum delectus quia possimus
                      provident repudiandae vel expedita ut atque? Cupiditate deserunt, magni minima quo facere magnam
                      quia obcaecati praesentium!
                      Officia dicta incidunt in deserunt eius. Culpa rem ut at, perspiciatis quis facilis doloribus
                      nostrum ducimus iusto, dolore distinctio a corrupti fugiat, reprehenderit quasi totam unde
                      similique
                      aliquam cum doloremque!
                      Inventore eligendi sint blanditiis perferendis delectus! Repudiandae nam labore, autem sapiente
                      officiis accusantium consectetur doloribus aperiam iste dolor sit beatae eligendi! Velit cumque id
                      incidunt inventore nostrum rem architecto officia!</p>
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab iusto illum delectus quia possimus
                      provident repudiandae vel expedita ut atque? Cupiditate deserunt, magni minima quo facere magnam
                      quia obcaecati praesentium!
                      Officia dicta incidunt in deserunt eius. Culpa rem ut at, perspiciatis quis facilis doloribus
                      nostrum ducimus iusto, dolore distinctio a corrupti fugiat, reprehenderit quasi totam unde
                      similique
                      aliquam cum doloremque!
                      Inventore eligendi sint blanditiis perferendis delectus! Repudiandae nam labore, autem sapiente
                      officiis accusantium consectetur doloribus aperiam iste dolor sit beatae eligendi! Velit cumque id
                      incidunt inventore nostrum rem architecto officia!</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>


  <!-- script -->
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
      crossorigin="anonymous"></script>
  <script type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


  <script>
      $(document).ready(() => {
          const apiUrl = 'http://localhost:1029/'

          $('#country').select2({
              placeholder: 'Select an option'
          })
          $('#province').select2()
          $('#city').select2()
          $('#Category_Product').select2()

          $('#check').click(function () {
              input = '#password';
              icon = '#icon-pass';
              if ($(input).attr('type') == 'password') {
                  $(input).prop('type', 'text');
                  $(icon).removeClass('text-secondary')
                  $(icon).addClass('text-info');
              } else {
                  $(icon).removeClass('text-info');
                  $(icon).addClass('text-secondary');
                  $(input).prop('type', 'password');
              }
          });
          $('#check2').click(function () {
              input = '#password_confirmation';
              icon = '#icon-pass2';
              if ($(input).attr('type') == 'password') {
                  $(input).prop('type', 'text');
                  $(icon).removeClass('text-secondary')
                  $(icon).addClass('text-info');
              } else {
                  $(icon).removeClass('text-info');
                  $(icon).addClass('text-secondary');
                  $(input).prop('type', 'password');
              }
          });
          $("#password_confirmation").on("keyup", function () {
              //Store the password field objects into variables ...
              var password = document.getElementById('password');
              var confirm = document.getElementById('password_confirmation');
              var message = document.getElementById('confirm-message2');
              //Set the colors we will be using ...
              var good_color = "#66cc66";
              var bad_color = "#ff6666";
              //Compare the values in the password field 
              //and the confirmation field
              if (password.value == confirm.value) {
                  //The passwords match. 
                  //Set the color to the good color and inform
                  //the user that they have entered the correct password 
                  confirm.style.borderColor = good_color;
                  message.style.color = good_color;
                  message.innerHTML = 'Match <i class="fa fa-check"></i>';
              } else {
                  //The passwords do not match.
                  //Set the color to the bad color and
                  //notify the user.
                  confirm.style.borderColor = bad_color;
                  message.style.color = bad_color;
                  message.innerHTML = 'Not Match <i class="fa fa-close"></i>';
              }
          });

          $.get(`${apiUrl}api/provinces`, res => {
              res.map(el => {
                  $('select#province').append(
                      `<option value='${el.id}' >${el.ProvinceName} </option> `)
              })
          })
          $.get(`${apiUrl}api/products`, res => {
              res.map(el => {
                  $('select#Category_Product').append(
                      `<option value='${el.product_name}' >${el.product_name} </option> `)
              })
          })



          $('#province').on('change', function () {
              $('#city').select2({
                  ajax: {
                      url: `${apiUrl}api/cities`,
                      dataType: 'json',
                      type: 'GET',
                      data: () => {
                          return {
                              province: $('#province').val()
                          }
                      }
                  }
              })
          })
          // create when error function
          const setTextError = (id, message) => {
              $(`label[for=${id}]`).addClass('error text-danger')
              const messageError = `<div id="${id}-error" class="error text-danger" for="${id}" style="display: block;">
                                <strong>${message.replace(/_/g," ")}</strong>
                            </div>`
              $(`input#${id}`).after(messageError)
              $(`select#${id}`).after(messageError)
          }

          const formValidate = () => {
              let status
              // get inputs form and convert to array
              const inputs = $('input').toArray();
              const selects = $('select').toArray()


              // check hint for is hidden
              if ($('#hint').is(':hidden')) {
                  status = true
              } else {
                  status = false
              }
              // check policy is checked
              if ($('#policy').prop('checked') == true) {
                  status = true
              } else {
                  $('#policy').focus()
                  setTextError('policy', 'Provacy Policy is required')
                  status = false
              }


              // check if input is null
              inputs.forEach(el => {
                  if (el.value == '') {
                      status = false
                  }
              });

              // check if select option is null
              selects.splice(0, 1)
              selects.forEach(el => {
                  if (el.selectedIndex == 0) {
                      status = false
                  }
              })


              return status
          }

          // check pass

          $('#password').keyup(() => {
              const pass = $('#password').val()
              if (pass.length < 14 && pass.length > 8) {
                  const reUpperCase = /[A-Z]/;
                  const reLowerCase = /[a-z]/;
                  const reNumeric = /[0-9]/;
                  const reSpecial = /[^\w\s]/gi;
                  if ((reUpperCase.test(pass) && reLowerCase.test(pass) && reNumeric.test(pass) &&
                          reSpecial.test(pass))) {
                      $('#hint').hide()
                  } else {
                      $('#hint').show()
                  }
              }
          })

          $('form').submit(() => {
              const validate = formValidate()
              if (!validate) {
                  event.preventDefault();
              }
          })
      })

  </script>
