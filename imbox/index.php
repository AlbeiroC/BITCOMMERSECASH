<?php
	include( './../cm/functions.php');
	if (!$user=is_session()) {
		header('Location: '.http().$_SERVER['HTTP_HOST'].'/login?next='.urlencode($_SERVER['REQUEST_URI']));
		exit();
	}

	if (!empty($_SESSION['notification'])) {
		$header  = '<div class="notification is-'.$_SESSION['notification']['icon'].'" style="border-radius:0px;margin:0px;margin-top:-9px;"><button class="delete"></button>';
		$header .= $_SESSION['notification']['texto'];
		$header .= '</div>';
		unset($_SESSION['notification']);
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=3, shrink-to-fit=no">
<link rel="icon"       type="text/css" href="./../img/icons/send_blue_1.png">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lobster">
<link rel="stylesheet" type="text/css" href="./../fonts/google.css" />
<link rel="stylesheet" type="text/css" href="./../css/select2.min.css" />
<link rel="stylesheet" type="text/css" href="./../css/bulma.css">
<link rel="stylesheet" type="text/css" href="./../css/jquery.tipsy.css" />
<link rel="stylesheet" type="text/css" href="./../css/menu.css" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet"  type="text/css" href="./../css/bulma.css">
<title>BitSend | BitCommerseCash</title>
<style>
* { margin: 0px; padding: 0px; }
html,body{
	background: #f0f1f2;
	font:12px "Open Sans", sans-serif;
	overflow:hidden;
}

#view-code{
  color:#89a2b5;    
  opacity:0.7;
  font-size:14px;
  text-transform:uppercase;
  font-weight:700;
  text-decoration:none;
  position:absolute;top:660px;
  left:50%;margin-left:-50px;
  z-index:200;
}
#view-code:hover{opacity:1;}
#chatbox{
	background:#fff;
	border-radius:6px;
	overflow:hidden;
	height:100vh;
}
#friendslist{
	left:0;
	width:100%;
	height:100vh;
}

#friends{
	overflow-y: auto;
	height: calc(100vh - (60px + 70px));
}


.topmenu{
	height:83px;
	width:100%;
	border-bottom:1px solid #d8dfe3;    
}

.topmenu .topmenu-item{
	position: relative;
	display: inline-block;
	float: left;
	height: 83px;
	color: #DBDBDB;
	cursor: pointer;
}

.topmenu .topmenu-item:hover{
	color: #BABABA;
}

.topmenu .topmenu-item.active{
	color: #00D1B2;
	border-bottom: solid 2px #09BF8E;
}

.topmenu span{
	position: absolute;
	float:left;
	width: 100%;
	height: 70px;
	font-size: 1.52rem;
	/*background: url("./../img/icons/top-menu.png") -3px -118px no-repeat;*/
}

.topmenu span.friends{margin-bottom:-1px;}
.topmenu span.chats{background-position:-95px 25px; cursor:pointer;}
.topmenu span.chats:hover{background-position:-95px -46px; cursor:pointer;}
.topmenu span.history{background-position:-190px 24px; cursor:pointer;}
.topmenu span.history:hover{background-position:-190px -47px; cursor:pointer;}
.friend{
	background: #f1f4f6;
	height:70px;
    border: none;
	border-bottom:1px solid #e7ebee;        
	position:relative;
    outline:  none;
    width:  100%;
}
.friend:hover{
	background:#E3E4E4;
	cursor:pointer;
}
.friend img{
	width:40px;
	border-radius:50%;
	margin:15px;
	float:left;
}
.floatingImg{
	width:40px;
	border-radius:50%;
	position:absolute;
	top:0;
	left:12px;
	border:3px solid #fff;
}
.friend p{
	padding:15px 0 0 0;         
	float:left;
	width:220px;
}
.friend p strong{
  font-weight:600;
  font-size:15px;
	color:#597a96;  

}
.friend p span{
	font-size:13px;
	font-weight:400;
	color:#aab8c2;
}
.friend .status{
	background:#26c281;
	border-radius:50%;  
	width:9px;
	height:9px;
	position:absolute;
	top:31px;
	right:17px;
}
.friend .status.away{background:#ffce54;}
.friend .status.inactive{background:#eaeef0;}
#search{
	background:#E3E9ED url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/search.png") no-repeat left center /20px;
	width:100%;
	bottom:0;
	left:0;
}
#searchfield{
	background:#E3E9ED;
	border:none;
	width: 100%;
	padding:15px 20px;
	font-size:14px;
	font-family:"Open Sans", sans-serif; 
	font-weight:400px;
	color:#8198ac;
}
#searchfield:focus{
	 outline: 0;
}
#chatview{
	width:100%;
	height:100vh;
	position:absolute;
	top:0;
	left:0; 
	display:none;
	background:#fff;
}
.profile-card{
	height:50px;
	overflow:hidden;
	text-align:center;
	color:#fff;
}
.p1 .profile-card{
    background: rgb(63,76,107); /* Old browsers */
    background: -moz-linear-gradient(-45deg, rgba(63,76,107,1) 0%, rgba(63,76,107,1) 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(-45deg, rgba(63,76,107,1) 0%,rgba(63,76,107,1) 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(135deg, rgba(63,76,107,1) 0%,rgba(63,76,107,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3f4c6b', endColorstr='#3f4c6b',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
.profile-card .avatar{
	width:68px;
	border:3px solid #fff;
	margin:23px 0 0;
	border-radius:50%;
}
.profile-card  p{
	font-weight:600;
	font-size:15px;
	margin:118px 0 -1px;
	opacity:0;
	-webkit-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
	   -moz-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
		-ms-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
		 -o-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
			transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000); 
}
.profile-card  p.animate{
	margin-top:97px;
	opacity:1;
	-webkit-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
	   -moz-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
		-ms-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
		 -o-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
			transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000); 
}
.profile-card  span{
	font-weight:400;
	font-size:11px;
}
#chat-messages{
	opacity:0;
	margin-top:30px;
	height:calc(100vh - (50px + 41px));
	overflow-y:scroll;  
	overflow-x:hidden;
	padding-right: 20px;
	-webkit-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
	   -moz-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
		-ms-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
		 -o-transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
			transition: all 200ms cubic-bezier(0.000, 0.995, 0.990, 1.000);
}
#chat-messages.animate{
	opacity:1;
	margin-top:0;
}
#chat-messages label{
	color:#aab8c2;
	font-weight:600;
	font-size:12px;
	text-align:center;
	margin:15px 0;
	width:100%;
	display:block;  
}
#chat-messages div.message{
	padding:0 0 30px 58px;
	clear:both;
	margin-bottom:45px;
}
#chat-messages div.message.right{
	  padding: 0 58px 30px 0;
	  margin-right: -19px;
	  margin-left: 19px;
}
#chat-messages .message img{
	  float: left;
	  margin-left: -38px;
	  border-radius: 50%;
	  width: 30px;
	  margin-top: 12px;
}
#chat-messages div.message.right img{
	float: right;   
	margin-left: 0;
	margin-right: -38px;    
}
.message .bubble{   
	background:#f0f4f7;
	font-size:13px;
	font-weight:600;
	padding:12px 13px;
	border-radius:5px 5px 5px 0px;
	color:#8495a3;
	position:relative;
	float:left;
}
#chat-messages div.message.right .bubble{
	float:right;
	border-radius:5px 5px 0px 5px ;
}
.bubble .corner{
	background:url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/bubble-corner.png") 0 0 no-repeat;
	position:absolute;
	width:7px;
	height:7px;
	left:-5px;
	bottom:0;
}
div.message.right .corner{
	background:url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/bubble-cornerR.png") 0 0 no-repeat;
	left:auto;
	right:-5px;
}
.bubble span{
	  color: #aab8c2 !important;
	  font-size: 11px !important;
	  right: 0 !important;
	  bottom: -22px !important;
}

#sendmessage input{
	background:#fff;
	font-family:"Open Sans", sans-serif; 
	font-weight:400px;
	color:#aab8c2;
	border-radius: 0px;
	outline: none;
	box-shadow: none;
	border-color: #ccc;
}

#close{
	position:absolute;
	top: 8px;   
	opacity:0.8;
	right: 10px;
	width:20px;
	height:20px;
	cursor:pointer;
}
#close:hover{
	opacity:1;
}
.cx, .cy{
	background:#fff;
	position:absolute;
	width:0px;
	top:15px;
	right:15px;
	height:3px;
	-webkit-transition: all 250ms ease-in-out;
	   -moz-transition: all 250ms ease-in-out;
		-ms-transition: all 250ms ease-in-out;
		 -o-transition: all 250ms ease-in-out;
			transition: all 250ms ease-in-out;
}
.cx.s1, .cy.s1{ 
	right:0;    
	width:20px; 
	-webkit-transition: all 100ms ease-out;
	   -moz-transition: all 100ms ease-out;
		-ms-transition: all 100ms ease-out;
		 -o-transition: all 100ms ease-out;
			transition: all 100ms ease-out;
}
.cy.s2{ 
	-ms-transform: rotate(50deg); 
	-webkit-transform: rotate(50deg); 
	transform: rotate(50deg);        
	-webkit-transition: all 100ms ease-out;
	   -moz-transition: all 100ms ease-out;
		-ms-transition: all 100ms ease-out;
		 -o-transition: all 100ms ease-out;
			transition: all 100ms ease-out;
}
.cy.s3{ 
	-ms-transform: rotate(45deg); 
	-webkit-transform: rotate(45deg); 
	transform: rotate(45deg);        
	-webkit-transition: all 100ms ease-out;
	   -moz-transition: all 100ms ease-out;
		-ms-transition: all 100ms ease-out;
		 -o-transition: all 100ms ease-out;
			transition: all 100ms ease-out;
}
.cx.s1{ 
	right:0;    
	width:20px; 
	-webkit-transition: all 100ms ease-out;
	   -moz-transition: all 100ms ease-out;
		-ms-transition: all 100ms ease-out;
		 -o-transition: all 100ms ease-out;
			transition: all 100ms ease-out;
}
.cx.s2{ 
	-ms-transform: rotate(140deg); 
	-webkit-transform: rotate(140deg); 
	transform: rotate(140deg);       
	-webkit-transition: all 100ms ease-out;
	   -moz-transition: all 100ms ease-out;
		-ms-transition: all 100ease-out;
		 -o-transition: all 100ms ease-out;
			transition: all 100ms ease-out;
}
.cx.s3{ 
	-ms-transform: rotate(135deg); 
	-webkit-transform: rotate(135deg); 
	transform: rotate(135deg);       
	-webkit-transition: all 100ease-out;
	   -moz-transition: all 100ms ease-out;
		-ms-transition: all 100ms ease-out;
		 -o-transition: all 100ms ease-out;
			transition: all 100ms ease-out;
}
#chatview, #sendmessage { 
overflow:hidden; 
border-radius:0px;
}
</style></head>
<body class="container">
<div id="chatbox" class="columns" style="margin-left: 0px;margin-right: 0px;">
	<div id="friendslist" style="">
		<div class="columns topmenu">
            <div class="column topmenu-item is-full is-full-desktop is-full-tablet is-full-touch is-full-mobile" style="border-bottom: solid 2px #3870FF;padding-bottom: 0px;width: 100%;">
                <a href="/profile">
                    <center>
                        <img data-src="./../img/logo/icon_original.png" style="height: 50px;width: 50px;margin-top: 15px;">
                    </center>
                </a>
            </div>                
		</div>
		<?php if (!empty($header)) {
			echo $header;
		} ?>
		<div id="search" class="is-hidden">
			<input type="text" id="searchfield" placeholder="Search contacts..." />
		</div>
		<div id="friends">
			<?php
                $or  = '';
                if (!empty($_GET['beetwen'])&&(is_numeric($_GET['beetwen']))) {
                    $or = " OR imbox.user = '".$_GET['beetwen']."' AND imbox.para = '".$user['user_id']."' ";
                }
				$sql = "SELECT imbox.id AS id,users.imagen AS picture, imbox.user AS send_by, users.username AS send_username,users.nombre AS nombre, imbox.mensaje AS mensaje, imbox.referencia AS referencia, imbox.status AS status, imbox.readed AS leido, imbox.fecha AS fecha FROM imbox, users WHERE imbox.para = '".$user['user_id']."' AND users.id = imbox.user ".$or." GROUP BY imbox.user ORDER BY imbox.readed DESC";
				if ($res=$con->query($sql)) {
					if ($res->num_rows>0) {
						while ($imbox=$res->fetch_array(MYSQLI_ASSOC)) {
                            $send_by = is_session(false,$imbox['send_by']);
							echo '<form action="" onsubmit="return false;">';
							echo '	<button class="friend" beetwen="'.$imbox['send_by'].'" username="@'.$send_by['user_username'].'">';
							echo '		<input type="hidden" name="from" value="'.$send_by['user_id'].'">';
							echo '		<input type="hidden" name="mktime" value="'.strtotime($imbox['fecha']).'">';
							echo '		<input type="hidden" name="from-picture" value="'.$imbox['picture'].'">';
							echo '		<img data-src="'.$send_by['user_imagen'].'" alt="Picture" style="width:40px;height:40px;" data-style='."'{".'"background-size":"cover"'."}'".'/>';
							echo '		<p>';
							echo '			<strong>'.$imbox['nombre'].'</strong>';
							echo '			<br>';
							echo '			<span>Abrir conversacion</span>';
							echo '		</p>';
							echo '		<div class="status '.str_replace('false','active',str_replace('true', 'inactive', strtolower(trim($imbox['status'])))).'" title="Mensaje '.str_replace('false','no',str_replace('true', '', strtolower(trim($imbox['status'])))).' leido"></div>';
							echo '	</button>';
							echo '</form>';
						}
					}
					else{
                        echo '<div style="padding-top:10px;padding-bottom:10px;text-align:center;">';
                        echo "No tienes mensajes";
                        echo '</div>';
                    }
                }
                else{
                    echo '<div style="padding-top:10px;padding-bottom:10px;text-align:center;">';
                    echo "Tuvimos un problema en el servidor";
                    echo '</div>';
				}
			?>
		</div>                
		
	</div>  
	
	<div id="chatview" class="p1" style="<?php if(!empty($or)){echo 'display:block;';}; ?>">      
		<div class="profile-card">
			<div id="close">
				<div class="cy"></div>
				<div class="cx"></div>
			</div>
			<p class="from-name"></p>
			<span class="from-username"></span>
		</div>
        <div class="buffer-bar" style="width: 100%;height: 2px;background: #f00;"></div>

		<div id="chat-messages" class="has-scroll no-rounded"></div>
		
		<div id="sendmessage">
			<form action="./../api_v1/imbox/imbox.php" method="post" id="submit_imbox">
				<input type="hidden" name="to" value="">
				<div class="field has-addons">
					<div class="control is-expanded">
						<input class="input is-large" autocomplete="off" name="response" type="text" placeholder="" />
					</div>
					<div class="control">
						<button class="button is-large" id="send">Enviar</button>
					</div>
				</div>
			</form>
		</div>
	
	</div>        
</div>  
<script src="./../js/cookie.js"></script>
<script src="./../js/jquery.min.js"></script>
<script defer src="./../js/fontawesome-all.min.js"></script>
<script src="./../js/moment.min.js"></script>
<script src="./../js/popper.min.js"></script>
<script src="./../js/jquery.tipsy.js"></script>
<script src="./../js/functions.js"></script>
<script src="./../js/plugins.js"></script>
<script src="./../api_v1/imbox/imbox.js"></script>
<script>
$(function(){



$(document)
.on('ready', function(event) {
    if (!empty($_GET('beetwen'))) {
        $('[beetwen="'+$_GET('beetwen')+'"]').trigger('click');
    }
})
.on('click', '.friend', function(event) {
    event.preventDefault();
    var friendBtn = $(this);
    var childOffset = friendBtn.offset();
    var parentOffset = friendBtn.parent().parent().offset();
    var childTop = childOffset.top - parentOffset.top;
    var clone = friendBtn.find('img').eq(0).clone();
    var top = childTop+12+"px";

    $(clone).css({'top': top}).addClass("floatingImg").appendTo("#chatbox");                                    
    setTimeout(function(){
        $(".profile-card p").addClass("animate");
        $(".profile-card").addClass("animate");
    }, 100);
    setTimeout(function(){
        $("#chat-messages").addClass("animate");
        $('.cx, .cy').addClass('s1');
        setTimeout(function(){
            $('.cx, .cy').addClass('s2');
        }, 100);
        setTimeout(function(){
            $('.cx, .cy').addClass('s3');
        }, 200);
    }, 150);                                                        
    $('.floatingImg').css('left','calc(50% - 34px)').animate({
        'width': "68px",
        'height': "68px",
        'top':'20px'
    }, 200);

    var name = friendBtn.find("p strong").html();
    var username = friendBtn.attr('username');
    var from = friendBtn.find('[name="from"]').val().trim();
    $('[name="response"]').attr('placeholder','Querido '+username);

    $(".profile-card .from-name").html(name);
    $(".profile-card .from-username").html(username);
    $('form [name="to"]').val(from);
    $(".message").not(".right").find("img").attr("data-src", $(clone).attr("data-src")).attr("data-style", $(clone).attr("data-style"));
    $('#friendslist').fadeOut();
    data_src();
    push(false,{'beetwen':from},'ref');
    $('#chatview').fadeIn('slow');
    partner = '#chat-messages';
    params = {
        partner:partner,
        from:from,
        after:0,
        before:"99999999999999999999"
    };
    getChat(params); 

    refreshChat = setInterval(function(){
        getChat(params);
    },2000);
})
.on('click', '#close', function(event) {
    event.preventDefault();
    push(false,false,'beetwen=false');
    $('#chat-messages').html('');
    $("#chat-messages, .profile-card, .profile-card p").removeClass("animate");
    $('.cx, .cy').removeClass("s1 s2 s3");
    $('.floatingImg').fadeOut('fast', function(){$('.floatingImg').remove()});              
    setTimeout(function(){
        $('#chatview').fadeOut();
        $('#friendslist').fadeIn();
    }, 50);
    clearInterval(refreshChat);
})
.on('submit', '#submit_imbox', function(event) {
    event.preventDefault();
    form = $(this);
    var imagen = $('.message.right').last().find('img').css('background-image').replace(/url\(\"/gi,'').replace(/\"\)/gi,'');
    input = form.find('[name="response"]');
    if (input.val().trim().length<=0) {return false;}
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize()+'&ajax=true',
        beforeSend:function(){
            input.attr('disabled','disabled').css({'background':'#ccc','color':'#fff'});
            mensaje = form.find('[name="response"]').val().trim();
            html = '';
            html += '<div class="message right" style="background: none;" strtime="sending">';
            html += '   <img data-src="'+imagen+'" alt="Imagen" data-style='+"'{"+'"background-size":"cover"'+"}'"+'/>';
            html += '   <div class="bubble">';
            html += '       '+mensaje;
            html += '       <div class="corner"></div>';
            html += '       <div id="markTime_sending" style="display:;" class="has-text-grey-lighter">Enviando...</div>';
            html += '   </div>';
            html += '</div>';
            // $('#chat-messages')
            // .append(html)
            // .animate({scrollTop:sctop },600);
            // data_src();
        },
        success:function(r){
            if (r.type!==undefined&&(r.type!='error')) {
                input.removeAttr('disabled').css({'background':'#fff','color':'#aab8c2'}).val('').focus();
                $('.message.right[strtime="sending"]').remove();
            }
        }
    });
    return false;
});

	
});
</script>
</body>
</html>
