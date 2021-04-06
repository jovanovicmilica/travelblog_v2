$(document).ready(function (){


    console.log(BASE_URL)

    console.log(STRANA)

    $("#login").click(login)
    $("#close").click(close)
    $("#register").click(register)
    $("#loginLink").click(logindiv)

    if(STRANA=='/'){
        getFeatured()
    }
    if(STRANA=='blog'){
        getAll()
        $("#btnSearch").click(search)
        ///$("#searchKey").keyup(search)
    }
    if(STRANA=='contact'){
        $("#btnSendMessage").click(sendMessage)
    }
    if(STRANA.indexOf('blog/')!=-1){
        getComments()
        $("#btnComment").click(postComment)
        getLike()
    }
    if(STRANA=='editProfile'){
        editProfile()
        $("#btnEditUser").click(editUser)
    }
    if(STRANA=="addPost"){
        $('#summernote').summernote();
        $("#addNewPost").click(addPost)
    }
    if(STRANA.indexOf("post/")!=-1){
        $('#summernote').summernote();
        $("#editPost").click(editPost)
    }
    if(STRANA=='admin'){
        $("#allPostsAdmin").click(allPostsAdmin)
        $("#allSponsors").click(getAllSponsors)
        $("#addSponsor").click(formAddSponsor)
        $("#allNetworks").click(getAllNetworks)
        $("#addNetwork").click(formAddNetwork)
        $("#allHashtags").click(getAllHashtags)
        $("#addHashtag").click(formAddHashtag)
        $("#allUsers").click(getAllUsers)
        $("#allMessages").click(getAllMessages)
        $("#allComments").click(getAllComments)
        $("#activity").click(getActivity)
    }
})

function login(e){
    e.preventDefault()
    $("#regLog").show()
    $("#logDiv").show()
    $("#regDiv").hide()
    $("#loginLink").removeClass("neaktivan")
    $("#register").addClass("neaktivan")
}

function register(e){
    e.preventDefault()
    $("#regDiv").show()
    $("#logDiv").hide()
    $("#loginLink").addClass("neaktivan")
    $("#register").removeClass("neaktivan")
}
function logindiv(){
    $("#regDiv").hide()
    $("#logDiv").show()
    $("#loginLink").removeClass("neaktivan")
    $("#register").addClass("neaktivan")
}
function close(e){
    e.preventDefault()
    $("#regLog").hide()
}


function getFeatured(){
    $.ajax({
        url:BASE_URL+"/features",
        method:"get",
        dataType:"json",
        success:function(data){
            printPosts(data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function printPosts(posts){
    var print=''
    for(let post of posts){
        print+=`
        <div class="post">
        <a href="${BASE_URL+'/blog/'+post.id}">
            <div>
                <img src="${BASE_URL+"/assets/images/"+post.img}" alt="${post.title}">
                <p>${post.title}</p>
                <hr>
                <p>Learn more</p>
            </div>
        </a>
        </div>
        `
    }

    $("#featuredPost").html(print)
}

function getAll(){
    var key=$("#searchKey").val()
    $.ajax({
        url:BASE_URL+"/all",
        method:"get",
        dataType:"json",
        data:{
            "key":key
        },
        success:function(data){
            printHashtags(data.hashtags)
            printPosts(data.posts.data)
            printLinks(data.posts)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function printHashtags(data){
    var print=''
    for(let d of data){
        print+=`<span>#${d.hashtag} </span>`
    }
    $("#hashtags").html(print)
}

function search(){
    var key=$("#searchKey").val()
    console.log(key)
    $.ajax({
        url:BASE_URL+"/all",
        method:"get",
        dataType:"json",
        data:{
            "key":key
        },
        success:function(data){
            if(data.posts.data.length==0){
                $("#featuredPost").html("There is no posts")
                $("#pagination").html("")
            }
            else{
                printHashtags(data.hashtags)
                printPosts(data.posts.data)
                printLinks(data.posts)
            }
            $("#searchKey").val(key)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function printLinks(data){
    //console.log(data)
    var print=''
    if(data.current_page>1){
        print+=`<a href="" class="linkovi" data-id="${data.current_page-1}">Previous</a>`
    }
    for(let i=1;i<=data.last_page;i++){
        print+=`<a href="" class="linkovi `
            if(i==data.current_page){
                print+=`active`
            }
        print+=`" data-id="${i}">${i}</a>`
    }
    if(data.current_page<data.last_page){
        print+=`<a href="" class="linkovi" data-id="${data.current_page+1}">Next</a>`
    }

    $("#pagination").html(print)
    ///klik na link, ajax

    $(".linkovi").click(paginacija)
}

function paginacija(e){
    e.preventDefault()
    var key=$("#searchKey").val()
    var page=this.dataset.id
    $.ajax({
        url:BASE_URL+"/all",
        method:"get",
        dataType:"json",
        data:{
            "page":page,
            "key":key
        },
        success:function(data){
            //console.log(data)
            printHashtags(data.hashtags)
            printPosts(data.posts.data)
            printLinks(data.posts)


        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

$("#btnLogin").click(function (){
    var email=$("#emailLog").val()
    var pass=$("#passLog").val()

    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regPass=/^.{8,15}$/;

    var errors=0


    if(!regEmail.test(email)){
        $("#errorEmail").html("E-mail formats: milica@gmail.com or milica.jovanovic.88.18@ict.edu.rs")
        errors++
    }
    else{
        $("#errorFName").html("")
    }
    if(!regPass.test(pass)){
        $("#errorPassword").html("Password has minimum 8, maximum 5 characters")
        errors++
    }
    else{
        $("#errorPassword").html("")
    }

    if(errors==0){
        $.ajax({
            url:BASE_URL+"/login",
            method:"POST",
            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            dataType:"json",
            data:{
                "_token":$('input[name="_token"]').val(),
                "email":email,
                "pass":pass
            },
            success:function(data){
                if(data=="ok"){
                    location.reload()
                }
                else{
                    $("#logDiv p").html("")
                    $("#errorLogin").html(data)
                }
            },
            error:function(xhr){
                if(xhr.status==422){
                    var errors=JSON.parse(xhr.responseText)
                    if(errors.errors.email!=null){
                        $("#errorEmail").html(errors.errors.email)
                    }
                    else{
                        $("#errorEmail").html("")
                    }
                    if(errors.errors.pass!=null){
                        $("#errorPassword").html(errors.errors.pass)
                    }
                    else{
                        $("#errorPassword").html("")
                    }
                }
                else{
                    $("#errorPassword").html(xhr.responseText)
                }
            }
        })
    }

})

function sendMessage(){
    var fName=$("#firstName").val()
    var lName=$("#lastName").val()
    var email=$("#email").val()
    var subject=$("#subject").val()
    var message=$("#message").val()

    var regFName=/^[A-Z][a-z]{2,19}$/;
    var regLName=/^[A-Z][a-z]{2,29}$/;
    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regSubject=/^[\w\s\d]+$/

    message=message.split(" ")

    var errors=0;

   if(!regFName.test(fName)){
        $("#errorFName").html("First name begins with capital letter nad have 3 letters minimum, 20 maximum")
        errors++
    }
    else{
        $("#errorFName").html("")
    }
    if(!regLName.test(lName)){
        $("#errorLName").html("Last name begins with capital letter nad have 3 letters minimum, 30 maximum")
        errors++
    }
    else{
        $("#errorLName").html("")
    }
    if(!regEmail.test(email)){
        $("#errorEmailMessage").html("E-mail formats: milica@gmail.com or milica.jovanovic.88.18@ict.edu.rs")
        errors++
    }
    else{
        $("#errorEmailMessage").html("")
    }
    if(!regSubject.test(subject)){
        $("#errorSubject").html("You have to write subject")
        errors++
    }
    else{
        $("#errorSubject").html("")
    }
    if(message.length<=9){
        $("#errorMessage").html("Message has 10 words minimum")
        errors++
    }
    else{
        $("#errorMessage").html("")
    }

    if(errors==0){
        $.ajax({
            url:BASE_URL+"/message",
            method:"POST",
            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            dataType:"json",
            data:{
                "_token":$('input[name="_token"]').val(),
                "fName":fName,
                "lName":lName,
                "email":email,
                "subject":subject,
                "message":message
            },
            success:function(data){
                $("#contactForm p").html("")
                $("#contactForm input[type='text']").val("")
                $("#contactForm textarea").val("")
                $("#messageMessage").html(data.data)
            },
            error:function(xhr){
                if(xhr.status==422){
                    var errors=JSON.parse(xhr.responseText)
                    if(errors.errors.fName!=null){
                        $("#errorFName").html(errors.errors.fName)
                    }
                    else{
                        $("#errorFName").html("")
                    }
                    if(errors.errors.lName!=null){
                        $("#errorLName").html(errors.errors.lName)
                    }
                    else{
                        $("#errorLName").html("")
                    }
                    if(errors.errors.email!=null){
                        $("#errorEmailMessage").html(errors.errors.email)
                    }
                    else{
                        $("#errorEmailMessage").html("")
                    }
                    if(errors.errors.subject!=null){
                        $("#errorSubject").html(errors.errors.subject)
                    }
                    else{
                        $("#errorSubject").html("")
                    }
                    if(errors.errors.message!=null){
                        $("#errorMessage").html(errors.errors.message)
                    }
                    else{
                        $("#errorMessage").html("")
                    }
                }
                else{
                    console.log(xhr)
                    $("#messageMessage").html(xhr.responseText.data)
                }
            }
        })
    }

}

$("#logout").click(function (e){
    e.preventDefault()
    $.ajax({
        url:BASE_URL+"/logout",
        method:"GET",
        dataType:"json",
        success:function(data){
            location.reload()
        },
        error:function(xhr){
            location.reload()
        }
    })
})

$("#btnRegister").click(function (){
    var fName=$("#fNameReg").val()
    var lName=$("#lNameReg").val()
    var email=$("#eMailReg").val()
    var pass=$("#passReg").val()
    var passConf=$("#passConfReg").val()

    var regFName=/^[A-Z][a-z]{2,19}$/;
    var regLName=/^[A-Z][a-z]{2,29}$/;
    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regPass=/^.{8,15}$/;

    var errors=0;

    if(!regFName.test(fName)){
        $("#errorfNameReg").html("First name begins with capital letter nad have 3 letters minimum, 20 maximum")
        errors++
    }
    else{
        $("#errorfNameReg").html("")
    }
    if(!regLName.test(lName)){
        $("#errorLnameReg").html("Last name begins with capital letter nad have 3 letters minimum, 30 maximum")
        errors++
    }
    else{
        $("#errorLnameReg").html("")
    }
    if(!regEmail.test(email)){
        $("#errorEMailReg").html("E-mail formats: milica@gmail.com or milica.jovanovic.88.18@ict.edu.rs")
        errors++
    }
    else{
        $("#errorEMailReg").html("")
    }
    if(!regPass.test(pass)){
        $("#errorPassReg").html("Password has minimum 8, maximum 5 characters")
        errors++
    }
    else{
        $("#errorPassReg").html("")
    }
    if(pass!=passConf){
        $("#errorPassConfReg").html("Passwords do not match")
        errors++
    }
    else{
        $("#errorPassConfReg").html("")
    }

    if(errors==0){
        $.ajax({
            url:BASE_URL+"/register",
            method:"POST",
            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            dataType:"json",
            data:{
                "_token":$('input[name="_token"]').val(),
                "fName":fName,
                "lName":lName,
                "email":email,
                "pass":pass,
                "passConf":passConf
            },
            success:function(data){
                $("#regDiv p").html("")
                if(data=="E-mail adresss is already taken"){
                    $("#errorEMailReg").html(data)
                }
                else{
                    $("#regDiv input[type='text']").val("")
                    $("#regDiv input[type='password']").val("")
                    $("#errorReg").html(data)
                }
            },
            error:function(xhr){
                if(xhr.status==422){
                    var errors=JSON.parse(xhr.responseText)
                    console.log(errors)
                    if(errors.errors.fName!=null){
                        $("#errorfNameReg").html(errors.errors.fName)
                    }
                    else{
                        $("#errorfNameReg").html("")
                    }
                    if(errors.errors.lName!=null){
                        $("#errorLnameReg").html(errors.errors.lName)
                    }
                    else{
                        $("#errorLnameReg").html("")
                    }
                    if(errors.errors.email!=null){
                        $("#errorEMailReg").html(errors.errors.email)
                    }
                    else{
                        $("#errorEMailReg").html("")
                    }
                    if(errors.errors.pass!=null){
                        $("#errorPassReg").html(errors.errors.pass)
                    }
                    else{
                        $("#errorPassReg").html("")
                    }
                }
                else{
                    console.log(xhr)
                    $("#errorReg").html(xhr.responseText)
                }
            }
        })
    }
})
function getComments(){
    var id=STRANA.split("/")[1]
    $.ajax({
        url:BASE_URL+"/comments/"+id,
        method:"GET",
        dataType:"json",
        success:function(data){
            if(data.length==0){
                $("#noComments").html("No comments yet");
                printComments(data)
            }
            else{
                printComments(data)
                $("#noComments").html("");
            }
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}
function printComments(comments){
    var print=''
    for(let c of comments){
        print+=`<div class="comment">`
            if(c.user){
                print+=`<div class="editDelete">
                    <a class="editComment" data-id="${c.idComment}" href="#"><i class="far fa-edit"></i></a>
                    <a class="deleteComment" data-id="${c.idComment}" href="#"><i class="fas fa-times"></i></a>
                    </div>`
            }
        print+=`<h3>${c.firstName} ${c.lastName}</h3>
        <p>${c.comment}</p>
        <p>${c.date}</p>
        </div>`
    }
    $("#commentsDiv").html(print)

    $(".deleteComment").click(deleteComment)
    $(".editComment").click(editComment)

}

function postComment(){
    var idPosta=STRANA.split("/")[1]
    var comment=$("#commentText").val()


    $.ajax({
        url:BASE_URL+"/comments",
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "_token":$('input[name="_token"]').val(),
            "idPost":idPosta,
            "comment":comment
        },
        success:function(data){
            getComments()
            $("#commentText").val("")
            $("#errorComment").html("")
        },
        error:function(xhr){
            var errors=JSON.parse(xhr.responseText)
            if(xhr.status==422){
                $("#errorComment").html(errors.errors.comment)
            }
            else{
                $("#errorComment").html(errors)
            }
        }
    })

}
function deleteComment(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:BASE_URL+"/comments/"+id,
        method:"delete",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "_token":$('input[name="_token"]').val()
        },
        success:function(data){
            getComments()
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}
function editComment(e){
    e.preventDefault()
    var id=this.dataset.id
    var div=$(this).parent().parent()
    $.ajax({
        url:BASE_URL+"/comments/"+id+"/edit",
        method:"get",
        dataType:"json",
        success:function(data){

            var print=`<textarea placeholder="Your comment" id="commentEditText">${data.data.comment}</textarea>
                <input type="hidden" value="${data.data.idComment}" id="idPostEdit"/>
                <p id="errorEditComment"></p>
                <input type="button" value="Edit comment" id="btnEditComment">`

            div.html(print)

            $("#btnEditComment").click(doEdit)
        },
        error:function(xhr){
            var errors=JSON.parse(xhr.responseText)
            if(xhr.status==422){
                $("#errorEditComment").html(errors.errors.comment)
            }
            else{
                $("#errorEditComment").html(errors)
            }
        }
    })



}

function doEdit(){
    var idComment=$("#idPostEdit").val()
    var text=$("#commentEditText").val()

    $.ajax({
        url:BASE_URL+"/comments",
        method:"put",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "_token":$('input[name="_token"]').val(),
            "idComment":idComment,
            "comment":text
        },
        success:function(data){
            getComments()
        },
        error:function(xhr){
            var errors=JSON.parse(xhr.responseText)
            if(xhr.status==422){
                $("#errorEditComment").html(errors.errors.comment)
            }
            else{
                $("#errorEditComment").html(errors)
            }
        }
    })

}
function getLike(){
    var id=STRANA.split("/")[1]
    $.ajax({
        url:BASE_URL+"/likes/"+id,
        method:"get",
        dataType:"json",
        success:function(data){
            $("#countLikes").html(data.likes+" Likes")
            if(data.liked){
                $("#like").html(`<i id="likedPost" class="fas fa-thumbs-up"></i>`)
            }
            else{
                $("#like").html(`<i id="likePost" class="far fa-thumbs-up"></i>`)
            }

            $("#likedPost").click(unlike)
            $("#likePost").click(like)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function unlike(e){
    e.preventDefault()
    var id=STRANA.split("/")[1]
    $.ajax({
        url:BASE_URL+"/likes/"+id,
        method:"delete",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "idPost":id,
            "_token":$('input[name="_token"]').val()
        },
        success:function(data){
            if(data.data=="Ok"){
                getLike()
            }
            else{
                $("#likeError").html(data.data)
            }
        },
        error:function(xhr){
            $("#likeError").html(xhr.responseText)
        }
    })
}

function like(e){
    e.preventDefault()
    var id=STRANA.split("/")[1]
    $.ajax({
        url:BASE_URL+"/likes",
        method:"post",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "idPost":id,
            "_token":$('input[name="_token"]').val()
        },
        success:function(data){
            if(data.data=="Ok"){
                getLike()
            }
            else{
                $("#likeError").html(data.data)
            }
        },
        error:function(xhr){
            $("#likeError").html(xhr.responseText)
        }
    })
}

function editProfile(){
    $.ajax({
        url:BASE_URL+"/userEdit",
        method:"get",
        dataType:"json",
        success:function(data){
            getUserInfo(data)
        },
        error:function(xhr){
            $("#userInfo").html(xhr.responseText)
        }
    })
}

function getUserInfo(data){
    var print=''
    print+=`<h2>${data.firstName} ${data.lastName}</h2>
            <p>${data.email}</p>`

    $("#userInfo").html(print)

    $("#userName").val(data.firstName)
    $("#userLname").val(data.lastName)
    $("#userEmail").val(data.email)


}

function editUser(){
    var fName=$("#userName").val()
    var lName=$("#userLname").val()
    var email=$("#userEmail").val()
    var pass=$("#newPass").val()


    $.ajax({
        url:BASE_URL+"/updateUser",
        method:"put",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "_token":$('input[name="_token"]').val(),
            "firstName":fName,
            "lastName":lName,
            "email":email,
            "password":pass
        },
        success:function(data){
            $("#editUserform p").html("")
            if(data=="E-mail adresss is already taken"){
                $("#errorEditEmail").html(data)
            }
            else{
                $("#errorEdit").html(data)

                editProfile()
            }
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                console.log(errors)
                if(errors.errors.fName!=null){
                    $("#errorEditFname").html(errors.errors.fName)
                }
                else{
                    $("#errorEditFname").html("")
                }
                if(errors.errors.lName!=null){
                    $("#errorEditLname").html(errors.errors.lName)
                }
                else{
                    $("#errorEditLname").html("")
                }
                if(errors.errors.email!=null){
                    $("#errorEditEmail").html(errors.errors.email)
                }
                else{
                    $("#errorEditEmail").html("")
                }
                if(errors.errors.password!=null){
                    $("#errorEditPass").html(errors.errors.password)
                }
                else{
                    $("#errorEditPass").html("")
                }
            }
            else{
                $("#errorEdit").html(xhr.responseText)
            }
        }
    })
}

function getActivity(e){
    e.preventDefault()
    var date=null
    $.ajax({
        url:BASE_URL+"/activity",
        method:"get",
        dataType:"json",
        data:{
            "date":date
        },
        success:function(data){
            var print="<h1>Activity</h1>"
            print+=`<form>
                        <select id="ddlActivity">
                            <option value="null">Choose</option>
                            <option value="-15 minutes">Last 15 minutes</option>
                            <option value="-30 minutes">Last 30 minutes</option>
                            <option value="-1 hour">Last 1 hour</option>
                            <option value="-1 day">Last 24h hours</option>
                        </select>
                    </form><div id="activityTable"></div>`
            $("#mainAdmin").html(print)
            $("#ddlActivity").change(getByTime)
            printActiviti(data)

        },
        error:function(xhr){
            mainAdmin.html(xhr.responseText)
        }
    })

}

function getByTime(){
    var date=this.value
    console.log(date)
    $.ajax({
        url:BASE_URL+"/activity",
        method:"get",
        dataType:"json",
        data:{
            "date":date
        },
        success:function(data){
            printActiviti(data)

        },
        error:function(xhr){
            mainAdmin.html(xhr.responseText)
        }
    })
}
function printActiviti(data){
    var printActiviti=''
    var podaci=data.log
    printActiviti+=`<table><tr><th>Ip address</th><th>Page</th><th>User</th><th>Action</th><th>Time</th></tr>`
    for(let d of podaci){
        printActiviti+=`<tr>
                                    <td>${d.split("\t")[0]}</td>
                                    <td>${d.split("\t")[1]}</td>
                                    <td>${d.split("\t")[3]}</td>
                                    <td>${d.split("\t")[4]}</td>
                                    <td>${d.split("\t")[5]}</td>
                                </tr>`
    }
    printActiviti+=`</table>`
    $("#activityTable").html(printActiviti)
}
function allPostsAdmin(e){
    e.preventDefault()
    $.ajax({
        url:BASE_URL+"/allAdmin",
        method:"get",
        dataType:"json",
        success:function(data){
            printPostsAdmin(data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function printPostsAdmin(data){
    var print=`<h1>All posts</h1>`
    print+=`<table>
    <tr><th>Title</th><th>Image</th><th>Likes</th><th>Comments</th><th>Approved</th><th>Delete</th></tr>
`
    for(let d of data){
        print+=`<tr>
            <td>${d.title}</td>
            <td><img src="${BASE_URL+"/assets/images/"+d.img}" alt="${d.title}"></td>
            <td>${d.likes}</td>
            <td>${d.comments}</td>`
            if(d.approved==1){
                print+=`<td>Approved</td>`
            }
            else{
                print+=`<td><a href="#" class="approvePost" data-id="${d.id}">Approve</a></td>`
            }
            print+=`<td><a href="#" class="deletePost" data-id="${d.id}">Delete</a></td>
            </tr>
            `;
    }

    print+='</table>'

    $("#mainAdmin").html(print)
    $(".deletePost").click(deltePost)
    $(".approvePost").click(approvePost)
}

function approvePost(e){
    e.preventDefault()
    var id=this.dataset.id
    var red=$(this).parent()
    console.log(red)
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allAdmin/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"put",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            red.html("Approved")
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function updatePostGet(e){
    e.preventDefault()
    var id=this.dataset.id
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allAdmin/"+id+"/edit",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"get",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            formAddPost(e,data);
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function deltePost(e){
    e.preventDefault()
    var id=this.dataset.id
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allAdmin/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"delete",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            allPostsAdmin(e);
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}


function editPost(){
    var title=document.getElementById("title").value
    var idPost=document.getElementById("idPostHidden").value
    var thumbnail=document.getElementById("thumbnail").files[0]
    var photosAll=document.getElementById("photos").files
    var post=document.getElementById("summernote").value
    var tags=document.getElementsByName("chbHash")
    var token=$('input[name="_token"]').val()


    var izborTags=[]

    var podaciZaSlanje=new FormData()

    for(let i=0;i<tags.length;i++){
        if(tags[i].checked){
            var checked=tags[i].value
            podaciZaSlanje.append("idHashtag[]",checked)
        }
    }

    if(thumbnail==undefined){
        thumbnail=""
    }


    for(let i=0;i<photosAll.length;i++){
        podaciZaSlanje.append("photos[]",photosAll[i])
    }



    podaciZaSlanje.append("title",title)
    podaciZaSlanje.append("thumbnail",thumbnail)
    podaciZaSlanje.append("summernote",post)
    podaciZaSlanje.append("_token",token)


    podaciZaSlanje.append("_method","put")

    $.ajax({
        url:BASE_URL+"/post/"+idPost,
        method:"post",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        processData:false,
        contentType:false,
        dataType:"json",
        data:podaciZaSlanje,
        success:function(data){
            $("#errorTitle").html("")
            $("#errorText").html("")
            $("#errorThumbnail").html("")
            $("#errorPhotos").html("")
            $("#errorInsert").html(data.data)
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                if(errors.errors.title!=null){
                    $("#errorTitle").html(errors.errors.title)
                }
                else{
                    $("#errorTitle").html("")
                }
                if(errors.errors.summernote!=null){
                    $("#errorText").html(errors.errors.summernote)
                }
                else{
                    $("#errorText").html("")
                }
                if(errors.errors.thumbnail!=null){
                    $("#errorThumbnail").html(errors.errors.thumbnail)
                }
                else{
                    $("#errorThumbnail").html("")
                }
                if(errors.errors.photos!=null){
                    $("#errorPhotos").html(errors.errors.photos)
                }
                else{
                    $("#errorPhotos").html("")
                }
            }
            else{
                $("#errorInsert").html(xhr.responseText)
            }
        }
    })

}

function deletePostImage(e){
    e.preventDefault()
    var id=this.dataset.id
    var red=$(this).parent().parent()
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/image/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"delete",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            red.remove()
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function addPost(){
    var title=document.getElementById("title").value
    var thumbnail=document.getElementById("thumbnail").files[0]
    var photosAll=document.getElementById("photos").files
    var post=document.getElementById("summernote").value
    var tags=document.getElementsByName("chbHash")
    var token=$('input[name="_token"]').val()


    var izborTags=[]

    var podaciZaSlanje=new FormData()

    for(let i=0;i<tags.length;i++){
        if(tags[i].checked){
            var checked=tags[i].value
            podaciZaSlanje.append("idHashtag[]",checked)
        }
    }


    for(let i=0;i<photosAll.length;i++){
        podaciZaSlanje.append("photos[]",photosAll[i])
    }



    podaciZaSlanje.append("title",title)
    podaciZaSlanje.append("thumbnail",thumbnail)
    podaciZaSlanje.append("summernote",post)
    podaciZaSlanje.append("_token",token)

    $.ajax({
        url:BASE_URL+"/userPost",
        method:"post",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        processData:false,
        contentType:false,
        dataType:"json",
        data:podaciZaSlanje,
        success:function(data){
            $("#errorTitle").html("")
            $("#errorText").html("")
            $("#errorThumbnail").html("")
            $("#errorPhotos").html("")
            $("#errorInsert").html(data.data)
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                if(errors.errors.title!=null){
                    $("#errorTitle").html(errors.errors.title)
                }
                else{
                    $("#errorTitle").html("")
                }
                if(errors.errors.summernote!=null){
                    $("#errorText").html(errors.errors.summernote)
                }
                else{
                    $("#errorText").html("")
                }
                if(errors.errors.thumbnail!=null){
                    $("#errorThumbnail").html(errors.errors.thumbnail)
                }
                else{
                    $("#errorThumbnail").html("")
                }
                if(errors.errors.photos!=null){
                    $("#errorPhotos").html(errors.errors.photos)
                }
                else{
                    $("#errorPhotos").html("")
                }
            }
            else{
                $("#errorInsert").html(xhr.responseText)
            }
        }
    })
}


function getAllSponsors(e){
    e.preventDefault()
    $.ajax({
        url:BASE_URL+"/allSponsors",
        method:"get",
        dataType:"json",
        success:function(data){
            getSponsorsAdmin(data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function getSponsorsAdmin(data){
    var print=`<h1>Sponsors</h1><table><tr><th>Name</th><th>Image</th><th>Update</th><th>Delete</th></tr>`
    for(let d of data){
        print+=`<tr>
            <td>${d.name}</td>
            <td><img src="${BASE_URL+'/assets/images/'+d.img}" alt="${d.name}"/></td>
            <td><a href="" class="formUpdateSponsr" data-id="${d.idSponsor}">Update</a> </td>
            <td><a href="" class="deleteSponsor" data-id="${d.idSponsor}">Delete</a> </td>
            </tr>`
    }
    print+=`</table>`
    $("#mainAdmin").html(print)
    $(".deleteSponsor").click(deleteSponsor)
    $(".formUpdateSponsr").click(getSponsorUpdate)
}
function getSponsorUpdate(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:BASE_URL+"/allSponsors/"+id+"/edit",
        method:"get",
        dataType:"json",
        success:function(data){
            formAddSponsor(e,data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}
function deleteSponsor(e){
    e.preventDefault()
    var id=this.dataset.id
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allSponsors/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"delete",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            getAllSponsors(e);
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}


function formAddSponsor(e,data=null){
    e.preventDefault()
    var print=""
    if(data!=null){
        print+=`<h1>Edit sponsor</h1>`
    }
    else{
        print+=`<h1>Add sponsor</h1>`
    }
    print+=`<form enctype="multipart/form-data">
        <input type="text" placeholder="Sponsor name"`
        if(data!=null){
            print+=`value="${data[0].name}"`
        }
        print+=`id="sponsorName">
        <p id="errorSponsorName"></p>
        <p>Image</p>
        <input type="file" id="sposnorPhoto">
        <p id="errorSponsorPhoto"></p>`
        if(data!=null){
            print+=`<input type="hidden" value="${data[0].idSponsor}" id="idSponsorHidden"/>
                <input type="button" value="Edit sponsor" id="btnEditSponsor"/>`
        }
        else{
            print+=`<input type="button" value="Add sponsor" id="btnAddSponsor"/>`
        }
        print+=`<p id="errorSponsor"></p>
        </form>`


    $("#mainAdmin").html(print)
    $("#btnEditSponsor").click(editSponsor)
    $("#btnAddSponsor").click(addSponsor)
}
function editSponsor(){
    var name=document.getElementById("sponsorName").value
    var id=document.getElementById("idSponsorHidden").value
    var img=document.getElementById("sposnorPhoto").files[0]

    var token=$('input[name="_token"]').val()

    var podaciZaSlanje=new FormData();

    if(img==undefined){
        img=""
    }

    podaciZaSlanje.append("name",name)
    podaciZaSlanje.append("img",img)
    podaciZaSlanje.append("_token",token)
    podaciZaSlanje.append("_method","put")

    $.ajax({
        url:BASE_URL+"/allSponsors/"+id,
        method:"post",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        processData:false,
        contentType:false,
        dataType:"json",
        data:podaciZaSlanje,
        success:function(data){
            $("form p").html("")
            $("#errorSponsor").html(data.data)
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                if(errors.errors.name!=null){
                    $("#errorSponsorName").html(errors.errors.name)
                }
                else{
                    $("#errorSponsorName").html("")
                }
                if(errors.errors.img!=null){
                    $("#errorSponsorPhoto").html(errors.errors.img)
                }
                else{
                    $("#errorSponsorPhoto").html("")
                }

            }
            else{
                $("#errorInsert").html(xhr.responseText)
            }
        }
    })
}
function addSponsor(){
    var name=document.getElementById("sponsorName").value
    var img=document.getElementById("sposnorPhoto").files[0]

    var podaciZaSlanje=new FormData();

    podaciZaSlanje.append("name",name)
    podaciZaSlanje.append("img",img)

    $.ajax({
        url:BASE_URL+"/allSponsors",
        method:"post",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        processData:false,
        contentType:false,
        dataType:"json",
        data:podaciZaSlanje,
        success:function(data){
            $("form p").html("")
            $("#errorSponsor").html(data.data)
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                if(errors.errors.name!=null){
                    $("#errorSponsorName").html(errors.errors.name)
                }
                else{
                    $("#errorSponsorName").html("")
                }
                if(errors.errors.img!=null){
                    $("#errorSponsorPhoto").html(errors.errors.img)
                }
                else{
                    $("#errorSponsorPhoto").html("")
                }

            }
            else{
                $("#errorInsert").html(xhr.responseText)
            }
        }
    })
}

function getAllNetworks(e){
    e.preventDefault()
    $.ajax({
        url:BASE_URL+"/allNetworks",
        method:"get",
        dataType:"json",
        success:function(data){
            printNetworks(data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function printNetworks(data){
    var print=`<h1>All networks</h1><table>
        <tr><th>Network</th><th>Icon</th><th>Update</th><th>Delete</th></tr>`

    for(let d of data){
        print+=`<tr>
                <td>${d.link}</td>
                <td><i class="${d.icon}"></i></td>
                <td><a href="" class="formUpdateNetwork" data-id="${d.idNetwork}">Update</a> </td>
                <td><a href="" class="deleteNetworkLink" data-id="${d.idNetwork}">Delete</a> </td>
                </tr>`
    }
    print+=`</table>`

    $("#mainAdmin").html(print)
    $(".deleteNetworkLink").click(deleteNetworkAdmin)
    $(".formUpdateNetwork").click(getFormUpdateNetwork)
}
function getFormUpdateNetwork(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:BASE_URL+"/allNetworks/"+id+"/edit",
        method:"get",
        dataType:"json",
        success:function(data){
            var print=`<h1>Edit network</h1>
                <form>

                <input type="text" id="networkLinkA" placeholder="Link" value="${data.data.link}">

                <input type="hidden" value="${data.data.idNetwork}" id="hiddenNetwork">

                <input type="button" value="Edit Link" id="btnEditNetwork"/>
                <p id="errorNetwork"></p>
            </form>`

            $("#mainAdmin").html(print)
            $("#btnEditNetwork").click(editNetwork)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })

}

function editNetwork(){
    var id=$("#hiddenNetwork").val()
    var link=$("#networkLinkA").val()

    var token=$('input[name="_token"]').val()


    $.ajax({
        url:BASE_URL+"/allNetworks/"+id,
        method:"put",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data: {
            "link":link,
            "_token":token
        },
        success:function(data){
            console.log(data)
            $("#errorNetwork").html(data.data)
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                if(errors.errors.link!=null){
                    $("#errorNetwork").html(errors.errors.link)
                }
                else{
                    $("#errorNetwork").html("")
                }

            }
            else{
                $("#errorNetwork").html(xhr.responseText)
            }
        }
    })


}
function  deleteNetworkAdmin(e){
    e.preventDefault()
    var id=this.dataset.id
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allNetworks/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"delete",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            getAllNetworks(e);
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}
function formAddNetwork(e){
    e.preventDefault()
    var print=`<h1>Add network</h1>`

    print+=`<form>
            <input type="text" placeholder="Link" id="networkLinkA">
            <p id="errorLink"></p>
            <input type="text" placeholder="Icon" id="networkIconA">
            <p id="errorIcon"></p>
            <input type="button" value="Add network" id="btNaddNetwork"/>
            <p id="errorNetwork"></p>
            </form>
            <p>Find icon here: <a href="https://fontawesome.com/">Link</a> and copy value of class </p>
            <p>Example : &lt;i&gt;class="fab fa-instagram">&lt;&sol;i&gt; copy fab fa-instagram</p>`

    $("#mainAdmin").html(print)

    $("#btNaddNetwork").click(addNetwork)
}

function addNetwork(){
    var link=$("#networkLinkA").val()
    var icon=$("#networkIconA").val()

    var token=$('input[name="_token"]').val()

    $.ajax({
        url:BASE_URL+"/allNetworks",
        method:"post",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "link":link,
            "icon":icon,
            "_token":token
        },
        success:function(data){
            $("form p").html("")
            $("#errorNetwork").html(data.data)
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                if(errors.errors.link!=null){
                    $("#errorLink").html(errors.errors.link)
                }
                else{
                    $("#errorLink").html("")
                }
                if(errors.errors.icon!=null){
                    $("#errorIcon").html(errors.errors.icon)
                }
                else{
                    $("#errorIcon").html("")
                }

            }
            else{
                $("#errorNetwork").html(xhr.responseText)
            }
        }
    })

}

function getAllHashtags(e){
    e.preventDefault()
    $.ajax({
        url:BASE_URL+"/allHashtags",
        method:"get",
        dataType:"json",
        success:function(data){
            console.log(data)
            printHashtagsAdmin(data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })

}

function printHashtagsAdmin(data){
    var print=`<h1>All hashtags</h1>`

    for(let d of data){
        print+=`<p>#${d.hashtag} <a href="" class="updateHash" data-id="${d.idHashtag}">Update</a>  <a href="" class="deleteHashtag" data-id="${d.idHashtag}">Delete</a> </p>`
    }

    $("#mainAdmin").html(print)
    $(".deleteHashtag").click(deleteHashtag)
    $(".updateHash").click(updateHashtag)
}

function updateHashtag(e){
    e.preventDefault()
    var id=this.dataset.id
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allHashtags/"+id+"/edit",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"get",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            formAddHashtag(e,data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function deleteHashtag(e){
    e.preventDefault()
    var id=this.dataset.id
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allHashtags/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"delete",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            getAllHashtags(e);
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}


function formAddHashtag(e,data=null){
    e.preventDefault()

    var print=`<h1>Add hashtag</h1>`

    if(data!=null){
        var print=`<h1>Edit hashtag</h1>`
    }
    else{
        var print=`<h1>Add hashtag</h1>`
    }

    print+=`<form>
            <input type="text" placeholder="Hashtag"`
    if(data!=null){
        print+=`value="${data.data.hashtag}"`
    }
    print+=`id="hashtagsValue">
            <p id="errorHashtagName"></p>`
    if(data!=null){
        print+=`<input type="hidden" value="${data.data.idHashtag}" id="idHashtagDelete"/>
            <input type="button" value="Edit hashtag" id="btnEditHashtag"/>`
    }
    else{
        print+=`<input type="button" value="Add hashtag" id="btnAddHashtag"/>`
    }
            print+=`<p id="errorHashtag"></p>
            </form>`

    $("#mainAdmin").html(print)
    $("#btnAddHashtag").click(addHashtag)
    $("#btnEditHashtag").click(editHashtag)
}
function editHashtag(){
    var hashtag=$("#hashtagsValue").val()
    var id=$("#idHashtagDelete").val()

    var token=$('input[name="_token"]').val()

    $.ajax({
        url:BASE_URL+"/allHashtags/"+id,
        method:"put",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "hashtag":hashtag,
            "_token":token
        },
        success:function(data){
            $("form p").html("")
            $("#errorHashtag").html(data.data)
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                if(errors.errors.hashtag!=null){
                    $("#errorHashtagName").html(errors.errors.hashtag)
                }
                else{
                    $("#errorHashtagName").html("")
                }

            }
            else{
                $("#errorNetwork").html(xhr.responseText)
            }
        }
    })
}
function addHashtag(){
    var hashtag=$("#hashtagsValue").val()

    var token=$('input[name="_token"]').val()

    $.ajax({
        url:BASE_URL+"/allHashtags",
        method:"post",
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        dataType:"json",
        data:{
            "hashtag":hashtag,
            "_token":token
        },
        success:function(data){
            $("form p").html("")
            $("#errorHashtag").html(data.data)
        },
        error:function(xhr){
            if(xhr.status==422){
                var errors=JSON.parse(xhr.responseText)
                if(errors.errors.hashtag!=null){
                    $("#errorHashtagName").html(errors.errors.hashtag)
                }
                else{
                    $("#errorHashtagName").html("")
                }

            }
            else{
                $("#errorNetwork").html(xhr.responseText)
            }
        }
    })


}
function getAllUsers(e){
    e.preventDefault()
    $.ajax({
        url:BASE_URL+"/allUsers",
        method:"get",
        dataType:"json",
        success:function(data){
            printUsers(data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function printUsers(data){
    var print=`<h1>All users</h1><table>
        <tr><th>Name</th><th>E-mail</th><th>Update</th></tr>`

    for(let d of data){
        print+=`<tr>
                <td>${d.firstName} ${d.lastName}</td>
                <td>${d.email}</td>
                <td><a href="" class="linkUpdateUser" data-id="${d.id}">Update</a> </td>
                </tr>`
    }
    print+=`</table>`

    $("#mainAdmin").html(print)
    $(".linkUpdateUser").click(updateForm)

}
function updateForm(e){
    e.preventDefault()
    var id=this.dataset.id
    $.ajax({
        url:BASE_URL+"/allUsers/"+id+"/edit",
        method:"get",
        dataType:"json",
        success:function(data){
            var print=`
                        <h2>${data.user.firstName} ${data.user.lastName}</h2>
                        <h3>${data.user.email}</h3>
                        <form>

                        <input type="password" placeholder="New password" id="newPasswordAdmin"/>
                        <p id="errorPassAdmin"></p>
                        <input type="hidden" id="hiddenIdUser" value="${data.user.id}">
                        <input type="button" value="Change password" id="btnUpdateUserAdmin">

                    </form>`

            $("#mainAdmin").html(print)
            $("#btnUpdateUserAdmin").click(adminUpdateUser)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function adminUpdateUser(){
    var id=$("#hiddenIdUser").val()
    var pass=$("#newPasswordAdmin").val()
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allUsers/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"put",
        dataType:"json",
        data:{
            "pass":pass,
            "_token":token
        },
        success:function(data){

            $("#errorPassAdmin").html(data.data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}
function getAllMessages(e){
    e.preventDefault()
    $.ajax({
        url:BASE_URL+"/allMessages",
        method:"get",
        dataType:"json",
        success:function(data){
            printMessages(data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function printMessages(data){
    var print=`<h1>All messages</h1><table>
        <tr><th>Name</th><th>E-mail</th><th>Subject</th><th>Message</th><th>Delete</th></tr>`

    for(let d of data){
        print+=`<tr>
                <td>${d.firstName} ${d.lastName}</td>
                <td>${d.email}</td>
                <td>${d.subject}</td>
                <td>${d.message}</td>
                <td><a href="" class="deleteUserLink" data-id="${d.id}">Delete</a> </td>
                </tr>`
    }
    print+=`</table>`

    $("#mainAdmin").html(print)
    $(".deleteUserLink").click(deleteMessageFunciton)
}
function deleteMessageFunciton(e){
    e.preventDefault()

    var id=this.dataset.id
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allMessages/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"delete",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            getAllMessages(e);
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}
function getAllComments(e){
    e.preventDefault()
    $.ajax({
        url:BASE_URL+"/allComments",
        method:"get",
        dataType:"json",
        success:function(data){
            printCommentsAdmin(data)
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}

function printCommentsAdmin(data){
    var print=`<h1>All Comments</h1><table>
        <tr><th>Name</th><th>E-mail</th><th>Comments</th><th>Delete</th></tr>`

    for(let d of data){
        print+=`<tr>
                <td>${d.firstName} ${d.lastName}</td>
                <td>${d.email}</td>
                <td>${d.comment}</td>
                <td><a href="" class="deleteComentLink" data-id="${d.idComment}">Delete</a> </td>
                </tr>`
    }
    print+=`</table>`

    $("#mainAdmin").html(print)
    $(".deleteComentLink").click(deleteCommentFunction)
}
function deleteCommentFunction(e){
    e.preventDefault()

    var id=this.dataset.id
    var token=$('input[name="_token"]').val()
    $.ajax({
        url:BASE_URL+"/allComments/"+id,
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        method:"delete",
        dataType:"json",
        data:{
            "_token":token
        },
        success:function(data){
            getAllComments(e);
        },
        error:function(xhr){
            console.log(xhr)
        }
    })
}
