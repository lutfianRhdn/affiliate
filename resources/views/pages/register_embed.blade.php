    <form action="{{url('/')}}/register/{{$id}}" id="RegForm" method="POST">
        <div>
            <label for="name">name : </label>
        <input type="text" name="name-{{$id}}" id="name-{{$id}}">
        </div>
        <div>
            <label for="email">email : </label>
            <input type="text" name="email-{{$id}}" id="email-{{$id}}">
        </div>
        <div>
            <label for="password">password : </label>
            <input type="password" name="password-{{$id}}" id="password-{{$id}}">
        </div>
        <div>
            <label for="confirmPassword">confirm Password : </label>
            <input type="password" name="password_confirmation-{{$id}}" id="confirm_password-{{$id}}">
        </div>
        <div>
            <label for="phone">phone : </label>
            <input type="text" name="phone-{{$id}}" id="phone-{{$id}}">
        </div>
        <div>
            <label for="address">address : </label>
            <input type="text" name="address-{{$id}}" id="address-{{$id}}">
        </div>
        <button type="submit">submit</button>
    </form>
    
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="{{url('/')}}/js/Validate.js"></script> --}}
