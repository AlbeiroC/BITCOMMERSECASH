    getChat = function(params={}){
            if ('object' != typeof params) {return false;};
            defaults = {
                partner:false,
                from:0,
                before:"90000000000000000000000000000000000000",
                after:0,
                toAdd:'prepend'
            };
            opt = $.extend(true, defaults, params);
            if (!$(opt.partner)[0]) {return false;};
            if (isNaN(opt.from)||isNaN(opt.before)||isNaN(opt.after)) {return false;}

            act = opt.toAdd;
            if (opt.toAdd=='prepend') {
                act = $(opt.partner).find('[id_imbox]').length>0 ? 'append' : 'prepend';
            }

            $.ajax({
                url: './../api_v1/imbox/imbox.php',
                data: opt,
                xhr:function(){
                    if (window.XMLHttpRequest){
                        xhr = new window.XMLHttpRequest();
                        if(xhr.overrideMimeType){
                            xhr.overrideMimeType( "text/json" );
                        }
                    }else{
                        xhr = new ActiveXObject('Microsoft.XMLHTTP');
                    }
                    return xhr;
                },
                error:function(err){
                    return this.success(err.responseText);
                },
                success:function(r){
                    if (r!='error') {
                        $('.friend[beetwen="'+opt.from+'"]').find('.status.active').last().removeClass('active').addClass('inactive');
                        fecha = 0;
                        i = 0;
                        while (r[i]) {
                            imbox = r[i];
                            my = imbox.my.replace(/true/gi,'right').replace(/false/gi,'left').trim().toLowerCase();
                            titulo = "Recibido "+imbox.ago.toLowerCase();
                            if (my=='right') {
                                titulo = "Enviado "+imbox.ago.toLowerCase();
                            }
                            html = '';
                            html += '<div class="message '+my+'" style="background: none;" strtime="'+imbox.markTime+'" id_imbox="'+imbox.id_imbox+'">';
                            html += '   <img title="@'+imbox.send_username.toLowerCase()+'" data-src="'+imbox.send_imagen+'" alt="Imagen" data-style='+"'{"+'"background-size":"cover"'+"}'"+'/>';
                            html += '   <div class="bubble" data-collapse="#markTime'+imbox.id_imbox+'" title="'+titulo+'">';
                            html += '       '+imbox.mensaje;
                            html += '       <div class="corner"></div>';
                            html += '       <div id="markTime'+imbox.id_imbox+'" style="display:;" class="has-text-grey-lighter">'+imbox.ago+'</div>';
                            html += '   </div>';
                            html += '</div>';
                            if (!$('[id_imbox="'+imbox.id_imbox+'"]')[0]) {
                                if (act=='prepend') {
                                    $(opt.partner).prepend(html);
                                }
                                else{
                                    $(opt.partner).append(html);
                                }
                                sctop = (document.getElementById("chat-messages").scrollHeight) ? document.getElementById("chat-messages").scrollHeight : 0;
                                $(opt.partner).animate({scrollTop:sctop },0);
                            }
                            i++;
                        }
                        haveAds = setCookie('have_ads');
                        if (haveAds=='undefined'||haveAds==false||empty(haveAds)) {
                            setCookie('have_ads','1',($.now()+500));
                            $.ajax({
                                url: './../api_v1/imbox/imbox.php',
                                data: {ads: 'true'},
                                success:function(r){
                                    adsHtml = adsForChat(r.id,r.producto,r.precio+' '+r.divisa);
                                    $('#chat-messages').append(adsHtml);
                                    sctop = (document.getElementById("chat-messages").scrollHeight) ? document.getElementById("chat-messages").scrollHeight : 0;
                                    $(opt.partner).animate({scrollTop:sctop },0);
                                }
                            });
                        }
                        data_src();
                        $('.message').find('[title].bubble').tipsy({
                            position:'left'
                        });
                        $('.message').find('[title]').not('.bubble').tipsy();
                    }
                }
            });
        };



function adsForChat(id=false,product='ortros productos',price='0,00 USD'){
    html  = '<div class="message ads right" style="background: none;" strtime="1520827200" id_imbox="45">';
    html += '    <div class="bubble" style="text-align: center;float: none;">';
    html += '        Te puede interesar: <a href="#product='+id+'">'+product+'</a> por tan solo '+price;
    html += '    </div>';
    html += '</div>';
    return html;
}