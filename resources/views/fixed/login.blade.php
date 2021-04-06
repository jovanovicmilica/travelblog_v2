<div id="regLog">
    <a href="#" id="close"><i class="fas fa-times"></i></a>
    <div id="linkoviLogReg">
        <a href="#" id="loginLink">Log in</a>
        <a href="#" id="register" class="neaktivan">Register</a>
    </div>
    <div id="logDiv">
        <h2>Log in</h2>
        <form>
            @csrf
            <input type="text" placeholder="E-mail" id="emailLog">
            <p id="errorEmail"></p>
            <input type="password" placeholder="Password" id="passLog">
            <p id="errorPassword"></p>
            <input type="button" value="Log in" id="btnLogin">
            <p id="errorLogin"></p>
        </form>
    </div>
    <div id="regDiv">
        <h2>Register</h2>
        <form>
            @csrf
            <input type="text" placeholder="First Name" id="fNameReg">
            <p id="errorfNameReg"></p>
            <input type="text" placeholder="Last Name" id="lNameReg">
            <p id="errorLnameReg"></p>
            <input type="text" placeholder="E-mail" id="eMailReg">
            <p id="errorEMailReg"></p>
            <input type="password" placeholder="Password" id="passReg">
            <p id="errorPassReg"></p>
            <input type="password" placeholder="Password confirm" id="passConfReg">
            <p id="errorPassConfReg"></p>
            <input type="button" value="Register" id="btnRegister">
            <p id="errorReg"></p>
        </form>
    </div>
</div>
