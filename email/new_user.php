<?php
  include('./../cm/function.beta.php');
  if (!empty($_GET['user'])&&$user=userInfo($_GET['user'])) {}
  $URL_TO_VALIDATE = host('url').'login?trp='.base64_encode(security(true)).'&closeUp='.date('Ymdhis').'&u='.$user['data']['user']['id'];
  $email = strtolower($user['data']['user']['email']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
    <head>
        <!--[if gte mso 9]><xml>
     <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
     </o:OfficeDocumentSettings>
    </xml><![endif]-->
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <meta content="width=device-width" name="viewport">
                <!--[if !mso]><!-->
                <meta content="IE=edge" http-equiv="X-UA-Compatible">
                    <!--<![endif]-->
                    <title>
                    </title>
                    <!--[if !mso]><!-- -->
                    <link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet" type="text/css">
                        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
                            <!--<![endif]-->
                            <style id="media-query" type="text/css">
                                body {
  margin: 0;
  padding: 0; }

table, tr, td {
  vertical-align: top;
  border-collapse: collapse; }

.ie-browser table, .mso-container table {
  table-layout: fixed; }

* {
  line-height: inherit; }

a[x-apple-data-detectors=true] {
  color: inherit !important;
  text-decoration: none !important; }

[owa] .img-container div, [owa] .img-container button {
  display: block !important; }

[owa] .fullwidth button {
  width: 100% !important; }

[owa] .block-grid .col {
  display: table-cell;
  float: none !important;
  vertical-align: top; }

.ie-browser .num12, .ie-browser .block-grid, [owa] .num12, [owa] .block-grid {
  width: 605px !important; }

.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
  line-height: 100%; }

.ie-browser .mixed-two-up .num4, [owa] .mixed-two-up .num4 {
  width: 200px !important; }

.ie-browser .mixed-two-up .num8, [owa] .mixed-two-up .num8 {
  width: 400px !important; }

.ie-browser .block-grid.two-up .col, [owa] .block-grid.two-up .col {
  width: 302px !important; }

.ie-browser .block-grid.three-up .col, [owa] .block-grid.three-up .col {
  width: 201px !important; }

.ie-browser .block-grid.four-up .col, [owa] .block-grid.four-up .col {
  width: 151px !important; }

.ie-browser .block-grid.five-up .col, [owa] .block-grid.five-up .col {
  width: 121px !important; }

.ie-browser .block-grid.six-up .col, [owa] .block-grid.six-up .col {
  width: 100px !important; }

.ie-browser .block-grid.seven-up .col, [owa] .block-grid.seven-up .col {
  width: 86px !important; }

.ie-browser .block-grid.eight-up .col, [owa] .block-grid.eight-up .col {
  width: 75px !important; }

.ie-browser .block-grid.nine-up .col, [owa] .block-grid.nine-up .col {
  width: 67px !important; }

.ie-browser .block-grid.ten-up .col, [owa] .block-grid.ten-up .col {
  width: 60px !important; }

.ie-browser .block-grid.eleven-up .col, [owa] .block-grid.eleven-up .col {
  width: 55px !important; }

.ie-browser .block-grid.twelve-up .col, [owa] .block-grid.twelve-up .col {
  width: 50px !important; }

@media only screen and (min-width: 625px) {
  .block-grid {
    width: 605px !important; }
  .block-grid .col {
    vertical-align: top; }
    .block-grid .col.num12 {
      width: 605px !important; }
  .block-grid.mixed-two-up .col.num4 {
    width: 200px !important; }
  .block-grid.mixed-two-up .col.num8 {
    width: 400px !important; }
  .block-grid.two-up .col {
    width: 302px !important; }
  .block-grid.three-up .col {
    width: 201px !important; }
  .block-grid.four-up .col {
    width: 151px !important; }
  .block-grid.five-up .col {
    width: 121px !important; }
  .block-grid.six-up .col {
    width: 100px !important; }
  .block-grid.seven-up .col {
    width: 86px !important; }
  .block-grid.eight-up .col {
    width: 75px !important; }
  .block-grid.nine-up .col {
    width: 67px !important; }
  .block-grid.ten-up .col {
    width: 60px !important; }
  .block-grid.eleven-up .col {
    width: 55px !important; }
  .block-grid.twelve-up .col {
    width: 50px !important; } }

@media (max-width: 625px) {
  .block-grid, .col {
    min-width: 320px !important;
    max-width: 100% !important;
    display: block !important; }
  .block-grid {
    width: calc(100% - 40px) !important; }
  .col {
    width: 100% !important; }
    .col > div {
      margin: 0 auto; }
  img.fullwidth, img.fullwidthOnMobile {
    max-width: 100% !important; }
  .no-stack .col {
    min-width: 0 !important;
    display: table-cell !important; }
  .no-stack.two-up .col {
    width: 50% !important; }
  .no-stack.mixed-two-up .col.num4 {
    width: 33% !important; }
  .no-stack.mixed-two-up .col.num8 {
    width: 66% !important; }
  .no-stack.three-up .col.num4 {
    width: 33% !important; }
  .no-stack.four-up .col.num3 {
    width: 25% !important; }
  .mobile_hide {
    min-height: 0px;
    max-height: 0px;
    max-width: 0px;
    display: none;
    overflow: hidden;
    font-size: 0px; } }
                            </style>
                        </link>
                    </link>
                </meta>
            </meta>
        </meta>
    </head>
    <body class="clean-body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #FFFFFF">
        <style id="media-query-bodytag" type="text/css">
            @media (max-width: 520px) {
      .block-grid {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

      .col {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

        .col > div {
          margin: 0 auto;
        }

      img.fullwidth {
        max-width: 100%!important;
      }
      img.fullwidthOnMobile {
        max-width: 100%!important;
      }
      .no-stack .col {
        min-width: 0!important;
        display: table-cell!important;
      }
      .no-stack.two-up .col {
        width: 50%!important;
      }
      .no-stack.mixed-two-up .col.num4 {
        width: 33%!important;
      }
      .no-stack.mixed-two-up .col.num8 {
        width: 66%!important;
      }
      .no-stack.three-up .col.num4 {
        width: 33%!important;
      }
      .no-stack.four-up .col.num3 {
        width: 25%!important;
      }
      .mobile_hide {
        min-height: 0px!important;
        max-height: 0px!important;
        max-width: 0px!important;
        display: none!important;
        overflow: hidden!important;
        font-size: 0px!important;
      }
    }
        </style>
        <!--[if IE]><div class="ie-browser"><![endif]-->
        <!--[if mso]><div class="mso-container"><![endif]-->
        <table cellpadding="0" cellspacing="0" class="nl-container" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #FFFFFF;width: 100%">
            <tbody>
                <tr style="vertical-align: top">
                    <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                        <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #FFFFFF;"><![endif]-->
                        <div style="background-color:#49a6e8;">
                            <div class="block-grid " style="Margin: 0 auto;min-width: 320px;max-width: 605px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#49a6e8;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 605px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="605" style=" width:605px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                                    <div class="col num12" style="min-width: 320px;max-width: 605px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: transparent; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 20px;padding-left: 20px;padding-top: 20px;padding-bottom: 20px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <a href="http://<?php echo host('url'); ?>" target="_blank">
                                                        <img align="center" alt="Image" border="0" class="center autowidth " src="<?php echo host('url'); ?>email/images/marketing-template_logo.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;width: 100%;max-width: 71px" title="Image" width="71">
                                                        </img>
                                                    </a>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 20px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#FFFFFF;font-family:'Bitter', Georgia, Times, 'Times New Roman', serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 20px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:14px;font-family:Bitter, Georgia, Times, 'Times New Roman', serif;color:#FFFFFF;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center">
                                                                <span style="font-size: 28px; line-height: 33px;">
                                                                    Bienvenido a
                                                                    <strong>
                                                                        BitCommerseCash
                                                                    </strong>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div align="center" class="button-container center " style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="[URL_VALIDATE]" style="height:31pt; v-text-anchor:middle; width:149pt;" arcsize="58%" strokecolor="#134C75" fillcolor="#134C75"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:16px;"><![endif]-->
                                                    <a href="<?php echo $URL_TO_VALIDATE; ?>" style="display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #134C75; border-radius: 24px; -webkit-border-radius: 24px; -moz-border-radius: 24px; max-width: 199px; width: 139px;width: auto; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; padding-top: 5px; padding-right: 30px; padding-bottom: 5px; padding-left: 30px; font-family: 'Open Sans', Helvetica, Arial, sans-serif;mso-border-alt: none" target="_blank">
                                                        <span style="font-size:16px;line-height:32px;">
                                                            <strong>
                                                                <span data-mce-style="font-size: 14px; line-height: 28px;" style="font-size: 14px; line-height: 28px;">
                                                                    ACTIVAR MI CUENTA
                                                                </span>
                                                            </strong>
                                                        </span>
                                                    </a>
                                                    <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
                                                </div>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <div style="line-height:10px;font-size:1px">
                                                    </div>
                                                    <img align="center" alt="Image" border="0" class="center autowidth " src="<?php echo host('url'); ?>email/images/marketing-template_hero-image.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 400px" title="Image" width="400">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div style="background-color:#F3F3F3;">
                            <div class="block-grid " style="Margin: 0 auto;min-width: 320px;max-width: 605px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#F3F3F3;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 605px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="605" style=" width:605px; padding-right: 0px; padding-left: 0px; padding-top:30px; padding-bottom:30px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                                    <div class="col num12" style="min-width: 320px;max-width: 605px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: transparent; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:30px; padding-bottom:30px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 0px;"><![endif]-->
                                                    <div style="color:#134C75;font-family:'Bitter', Georgia, Times, 'Times New Roman', serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 0px;">
                                                        <div style="line-height:14px;font-family:Bitter, Georgia, Times, 'Times New Roman', serif;font-size:12px;color:#134C75;text-align:left;">
                                                            <p style="margin: 0;line-height: 14px;text-align: center;font-size: 12px">
                                                                <span style="font-size: 28px; line-height: 33px;">
                                                                    <b>
                                                                        Buenos negocios, con cuentas claras.
                                                                    </b>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:150%; padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:18px;font-family:'Open Sans', Helvetica, Arial, sans-serif;color:#7E7E7E;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">
                                                                Este correo electronico esta dirigido a
                                                                <?php echo $email; ?>
                                                                , en caso de no ser usted puede omitir esta informacion.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div style="background-color:#F3F3F3;">
                            <div class="block-grid " style="Margin: 0 auto;min-width: 320px;max-width: 605px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#F3F3F3;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 605px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="605" style=" width:605px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                                    <div class="col num12" style="min-width: 320px;max-width: 605px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: transparent; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div style="background-color:#F3F3F3;">
                            <div class="block-grid two-up " style="Margin: 0 auto;min-width: 320px;max-width: 605px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#F3F3F3;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 605px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="276" style="background-color:#FFFFFF; width:276px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 13px solid #f3f3f3; border-bottom: 0px solid transparent; border-right: 13px solid #f3f3f3;" valign="top"><![endif]-->
                                    <div class="col num6" style="max-width: 320px;min-width: 302px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: #FFFFFF; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 13px solid #f3f3f3; border-bottom: 0px solid transparent; border-right: 13px solid #f3f3f3; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <div align="center" class="img-container center autowidth fullwidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_top-tile.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 276.5px" title="Image" width="276.5">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 20px;padding-left: 20px;padding-top: 20px;padding-bottom: 20px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <a href="http://<?php echo host('url'); ?>" target="_blank">
                                                        <img align="center" alt="Image" border="0" class="center autowidth " src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_icon-tile_01.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;width: 100%;max-width: 115px" title="Image" width="115">
                                                        </img>
                                                    </a>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 25px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#134C75;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 25px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:14px;color:#134C75;font-family:'Open Sans', Helvetica, Arial, sans-serif;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center">
                                                                <strong>
                                                                    <span style="font-size: 18px; line-height: 21px;">
                                                                        FINANZAS
                                                                    </span>
                                                                </strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:150%; padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:18px;color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">
                                                                BitCommerseCash abre al mundo la libertad financiera proyectando Bitcoin como metodo de pago descentralizado.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <img align="center" alt="Image" border="0" class="center autowidth " src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_bottom-tile.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 274px" title="Image" width="274">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td><td align="center" width="276" style="background-color:#FFFFFF; width:276px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 13px solid #f3f3f3; border-bottom: 0px solid transparent; border-right: 13px solid #f3f3f3;" valign="top"><![endif]-->
                                    <div class="col num6" style="max-width: 320px;min-width: 302px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: #FFFFFF; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 13px solid #f3f3f3; border-bottom: 0px solid transparent; border-right: 13px solid #f3f3f3; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <div align="center" class="img-container center autowidth fullwidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_top-tile.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 276.5px" title="Image" width="276.5">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 20px;padding-left: 20px;padding-top: 20px;padding-bottom: 20px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <a href="http://<?php echo host('url'); ?>" target="_blank">
                                                        <img align="center" alt="Image" border="0" class="center autowidth " src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_icon-tile_01.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;width: 100%;max-width: 115px" title="Image" width="115">
                                                        </img>
                                                    </a>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 25px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#134C75;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 25px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:14px;color:#134C75;font-family:'Open Sans', Helvetica, Arial, sans-serif;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center">
                                                                <strong>
                                                                    <span style="font-size: 18px; line-height: 21px;">
                                                                        PRACTICO
                                                                    </span>
                                                                </strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:150%; padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:18px;color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">
                                                                Te damos un tour facil y sencillo, con unos pocos pasos habras logrado tu libertad financiera.
                                                            </p>
                                                            <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">
                                                                <br data-mce-bogus="1"/>
                                                            </p>
                                                            <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">
                                                                <br data-mce-bogus="1"/>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <img align="center" alt="Image" border="0" class="center autowidth " src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_bottom-tile.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 274px" title="Image" width="274">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div style="background-color:#f3f3f3;">
                            <div class="block-grid " style="Margin: 0 auto;min-width: 320px;max-width: 605px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#f3f3f3;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 605px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="605" style=" width:605px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                                    <div class="col num12" style="min-width: 320px;max-width: 605px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: transparent; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 5px;padding-left: 5px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="0px" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #dddddd;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div style="background-color:#F3F3F3;">
                            <div class="block-grid two-up " style="Margin: 0 auto;min-width: 320px;max-width: 605px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:#F3F3F3;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 605px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="276" style="background-color:#FFFFFF; width:276px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 13px solid #f3f3f3; border-bottom: 0px solid transparent; border-right: 13px solid #f3f3f3;" valign="top"><![endif]-->
                                    <div class="col num6" style="max-width: 320px;min-width: 302px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: #FFFFFF; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 13px solid #f3f3f3; border-bottom: 0px solid transparent; border-right: 13px solid #f3f3f3; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <div align="center" class="img-container center autowidth fullwidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_top-tile.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 276.5px" title="Image" width="276.5">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 20px;padding-left: 20px;padding-top: 20px;padding-bottom: 20px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <a href="http://<?php echo host('url'); ?>" target="_blank">
                                                        <img align="center" alt="Image" border="0" class="center autowidth " src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_icon-tile_01.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;width: 100%;max-width: 115px" title="Image" width="115">
                                                        </img>
                                                    </a>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 25px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#134C75;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 25px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:14px;color:#134C75;font-family:'Open Sans', Helvetica, Arial, sans-serif;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center">
                                                                <strong>
                                                                    <span style="font-size: 18px; line-height: 21px;">
                                                                        VENTAS
                                                                    </span>
                                                                </strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:150%; padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:18px;color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">
                                                                <br data-mce-bogus="1"/>
                                                            </p>
                                                            <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">
                                                                Convierte tu negocio fisico en una verdadera tienda virtual.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <img align="center" alt="Image" border="0" class="center autowidth " src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_bottom-tile.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 274px" title="Image" width="274">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td><td align="center" width="276" style="background-color:#FFFFFF; width:276px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 13px solid #f3f3f3; border-bottom: 0px solid transparent; border-right: 13px solid #f3f3f3;" valign="top"><![endif]-->
                                    <div class="col num6" style="max-width: 320px;min-width: 302px;display: table-cell;vertical-align: top;">
                                        <div style="background-color: #FFFFFF; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 13px solid #f3f3f3; border-bottom: 0px solid transparent; border-right: 13px solid #f3f3f3; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <div align="center" class="img-container center autowidth fullwidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_top-tile.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 276.5px" title="Image" width="276.5">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 20px;padding-left: 20px;padding-top: 20px;padding-bottom: 20px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <a href="http://<?php echo host('url'); ?>" target="_blank">
                                                        <img align="center" alt="Image" border="0" class="center autowidth " src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_icon-tile_01.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;width: 100%;max-width: 115px" title="Image" width="115">
                                                        </img>
                                                    </a>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 25px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#134C75;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 25px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:14px;font-family:'Open Sans', Helvetica, Arial, sans-serif;color:#134C75;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 17px;text-align: center">
                                                                <strong>
                                                                    <span style="font-size: 18px; line-height: 21px;">
                                                                        COMPRAS
                                                                    </span>
                                                                </strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:150%; padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:18px;color:#7E7E7E;font-family:'Open Sans', Helvetica, Arial, sans-serif;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center">
                                                                Busca y compra la mercancia que necesitas sin limites ni restricciones.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <table border="0" cellpadding="0" cellspacing="0" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="0px" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%" width="100%">
                                                                    <tbody>
                                                                        <tr style="vertical-align: top">
                                                                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                                                <span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div align="center" class="img-container center autowidth " style="padding-right: 0px;  padding-left: 0px;">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
                                                    <img align="center" alt="Image" border="0" class="center autowidth " src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/47/marketing-template_bottom-tile.jpg" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 274px" title="Image" width="274">
                                                        <!--[if mso]></td></tr></table><![endif]-->
                                                    </img>
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <div style="background-color:transparent;">
                            <div class="block-grid mixed-two-up " style="Margin: 0 auto;min-width: 320px;max-width: 605px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                                <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 605px;"><tr class="layout-full-width" style="background-color:transparent;"><![endif]-->
                                    <!--[if (mso)|(IE)]><td align="center" width="403" style=" width:403px; padding-right: 0px; padding-left: 0px; padding-top:15px; padding-bottom:15px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                                    <div class="col num8" style="display: table-cell;vertical-align: top;min-width: 320px;max-width: 400px;">
                                        <div style="background-color: transparent; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                                                <!--<![endif]-->
                                                <div class="">
                                                    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
                                                    <div style="color:#8F8F8F;font-family:'Open Sans', Helvetica, Arial, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
                                                        <div style="font-size:12px;line-height:14px;color:#8F8F8F;font-family:'Open Sans', Helvetica, Arial, sans-serif;text-align:left;">
                                                            <p style="margin: 0;font-size: 14px;line-height: 17px">
                                                                <span style="font-size: 11px; line-height: 13px;">
                                                                    Copyright © 2016 BitCommerseCash, All rights reserved.
                                                                </span>
                                                                <br/>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!--[if mso]></td></tr></table><![endif]-->
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td><td align="center" width="202" style=" width:202px; padding-right: 10px; padding-left: 10px; padding-top:15px; padding-bottom:15px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
                                    <div class="col num4" style="display: table-cell;vertical-align: top;max-width: 320px;min-width: 200px;">
                                        <div style="background-color: transparent; width: 100% !important;">
                                            <!--[if (!mso)&(!IE)]><!-->
                                            <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 10px; padding-left: 10px;">
                                                <!--<![endif]-->
                                                <div align="center" class="" style="padding-right: 10px; padding-left: 10px; padding-bottom: 10px;">
                                                    <div style="line-height:10px;font-size:1px">
                                                    </div>
                                                    <div style="display: table; max-width:77px;">
                                                        <!--[if (mso)|(IE)]><table width="57" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-collapse:collapse; padding-right: 10px; padding-left: 10px; padding-bottom: 10px;"  align="center"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace: 0pt;mso-table-rspace: 0pt; width:57px;"><tr><td width="32" style="width:32px; padding-right: 5px;" valign="top"><![endif]-->
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" height="32" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;Margin-right: 0" width="32">
                                                            <tbody>
                                                                <tr style="vertical-align: top">
                                                                    <td align="left" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top" valign="middle">
                                                                        <a href="https://www.facebook.com/Bitcommercash/" target="_blank" title="Facebook">
                                                                            <img alt="Facebook" src="images/facebook.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important" title="Facebook" width="32">
                                                                            </img>
                                                                        </a>
                                                                        <div style="line-height:5px;font-size:1px">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                                    </div>
                                                </div>
                                                <!--[if (!mso)&(!IE)]><!-->
                                            </div>
                                            <!--<![endif]-->
                                        </div>
                                    </div>
                                    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                                </div>
                            </div>
                        </div>
                        <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                    </td>
                </tr>
            </tbody>
        </table>
        <!--[if (mso)|(IE)]></div><![endif]-->
    </body>
</html>