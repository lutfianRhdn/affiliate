 const url = $('#RegForm').attr('action');
        $('#RegForm').on('submit',()=>{
            
            event.preventDefault();
            // $("#RegForm").load();
            $.ajax({
                url:url,
                type:'POST',
                dataType:'json',
                data:{
                    name:$('input[name=name]').val(),
                    email:$('input[name=email]').val(),
                    password:$('input[name=password]').val(),
                    password_confirmation:$('input[name=password_confirmation]').val(),
                    phone:$('input[name=phone]').val(),
                    address:$('input[name=address]').val()
                }
            }).done(res=>{
                // on error
                if(res.errors){
                    Object.keys(res.errors).map(item => {
                        let message = res.errors[item].message;
                        // let errorText = 
                        $(`#error-${item}`).remove()
                        if(!message){
                            return $(`input[name=${item}]`).after( `<p class="error" id="error-${item}">${res.errors[item]}</p>` )
                        }
                        return $(`input[name=${item}]`).after(`<p class="error"  id="error-${item}">${res.errors[item].message}</p>`)
                    });
                }
                else{
                $(`.error`).remove()
                }

            })
        })