
$email_temp = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><!--[if IE]><html xmlns=\"http://www.w3.org/1999/xhtml\" class=\"ie-browser\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\"><![endif]--><!--[if !IE]><!--><html style=\"margin: 0;padding: 0;\" xmlns=\"http://www.w3.org/1999/xhtml\"><!--<![endif]--><head>";
$email_temp .= "    <!--[if gte mso 9]><xml>";
$email_temp .= "     <o:OfficeDocumentSettings>";
$email_temp .= "      <o:AllowPNG/>";
$email_temp .= "      <o:PixelsPerInch>96</o:PixelsPerInch>";
$email_temp .= "     </o:OfficeDocumentSettings>";
$email_temp .= "    </xml><![endif]-->";
$email_temp .= "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
$email_temp .= "    <meta name=\"viewport\" content=\"width=device-width\">";
$email_temp .= "    <!--[if !mso]><!--><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"><!--<![endif]-->";
$email_temp .= "    <title>Template Base</title>";
$email_temp .= "    <style type=\"text/css\" id=\"media-query\">";
$email_temp .= "      body {";
$email_temp .= "  margin: 0;";
$email_temp .= "  padding: 0; }";

$email_temp .= "table {";
$email_temp .= "  border-collapse: collapse;";
$email_temp .= "  table-layout: fixed; }";

$email_temp .= "* {";
$email_temp .= "  line-height: inherit; }";

$email_temp .= "a[x-apple-data-detectors=true] {";
$email_temp .= "  color: inherit !important;";
$email_temp .= "  text-decoration: none !important; }";

$email_temp .= "[owa] .img-container div, [owa] .img-container button {";
$email_temp .= "  display: block !important; }";

$email_temp .= "[owa] .fullwidth button {";
$email_temp .= "  width: 100% !important; }";

$email_temp .= ".ie-browser .col, [owa] .block-grid .col {";
$email_temp .= "  display: table-cell;";
$email_temp .= "  float: none !important;";
$email_temp .= "  vertical-align: top; }";

$email_temp .= ".ie-browser .num12, .ie-browser .block-grid, [owa] .num12, [owa] .block-grid {";
$email_temp .= "  width: 500px !important; }";

$email_temp .= ".ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {";
$email_temp .= "  line-height: 100%; }";

$email_temp .= ".ie-browser .mixed-two-up .num4, [owa] .mixed-two-up .num4 {";
$email_temp .= "  width: 164px !important; }";

$email_temp .= ".ie-browser .mixed-two-up .num8, [owa] .mixed-two-up .num8 {";
$email_temp .= "  width: 328px !important; }";

$email_temp .= ".ie-browser .block-grid.two-up .col, [owa] .block-grid.two-up .col {";
$email_temp .= "  width: 250px !important; }";

$email_temp .= ".ie-browser .block-grid.three-up .col, [owa] .block-grid.three-up .col {";
$email_temp .= "  width: 166px !important; }";

$email_temp .= ".ie-browser .block-grid.four-up .col, [owa] .block-grid.four-up .col {";
$email_temp .= "  width: 125px !important; }";

$email_temp .= ".ie-browser .block-grid.five-up .col, [owa] .block-grid.five-up .col {";
$email_temp .= "  width: 100px !important; }";

$email_temp .= ".ie-browser .block-grid.six-up .col, [owa] .block-grid.six-up .col {";
$email_temp .= "  width: 83px !important; }";

$email_temp .= ".ie-browser .block-grid.seven-up .col, [owa] .block-grid.seven-up .col {";
$email_temp .= "  width: 71px !important; }";

$email_temp .= ".ie-browser .block-grid.eight-up .col, [owa] .block-grid.eight-up .col {";
$email_temp .= "  width: 62px !important; }";

$email_temp .= ".ie-browser .block-grid.nine-up .col, [owa] .block-grid.nine-up .col {";
$email_temp .= "  width: 55px !important; }";
$email_temp .= ".ie-browser .block-grid.ten-up .col, [owa] .block-grid.ten-up .col {";
$email_temp .= "  width: 50px !important; }";
$email_temp .= ".ie-browser .block-grid.eleven-up .col, [owa] .block-grid.eleven-up .col {";
$email_temp .= "  width: 45px !important; }";

$email_temp .= ".ie-browser .block-grid.twelve-up .col, [owa] .block-grid.twelve-up .col {";
$email_temp .= "  width: 41px !important; }";
$email_temp .= "@media only screen and (min-width: 520px) {";
$email_temp .= "  .block-grid {";
$email_temp .= "    width: 500px !important; }";
$email_temp .= "  .block-grid .col {";
$email_temp .= "    display: table-cell;";
$email_temp .= "    Float: none !important;";
$email_temp .= "    vertical-align: top; }";
$email_temp .= "    .block-grid .col.num12 {";
$email_temp .= "      width: 500px !important; }";
$email_temp .= "  .block-grid.mixed-two-up .col.num4 {";
$email_temp .= "    width: 164px !important; }";
$email_temp .= "  .block-grid.mixed-two-up .col.num8 {";
$email_temp .= "    width: 328px !important; }";
$email_temp .= "  .block-grid.two-up .col {";
$email_temp .= "    width: 250px !important; }";
$email_temp .= "  .block-grid.three-up .col {";
$email_temp .= "    width: 166px !important; }";
$email_temp .= "  .block-grid.four-up .col {";
$email_temp .= "    width: 125px !important; }";
$email_temp .= "  .block-grid.five-up .col {";
$email_temp .= "    width: 100px !important; }";
$email_temp .= "  .block-grid.six-up .col {";
$email_temp .= "    width: 83px !important; }";
$email_temp .= "  .block-grid.seven-up .col {";
$email_temp .= "    width: 71px !important; }";
$email_temp .= "  .block-grid.eight-up .col {";
$email_temp .= "    width: 62px !important; }";
$email_temp .= "  .block-grid.nine-up .col {";
$email_temp .= "    width: 55px !important; }";
$email_temp .= "  .block-grid.ten-up .col {";
$email_temp .= "    width: 50px !important; }";
$email_temp .= "  .block-grid.eleven-up .col {";
$email_temp .= "    width: 45px !important; }";
$email_temp .= "  .block-grid.twelve-up .col {";
$email_temp .= "    width: 41px !important; } }";
$email_temp .= "@media (max-width: 520px) {";
$email_temp .= "  .block-grid, .col {";
$email_temp .= "    min-width: 320px !important;";
$email_temp .= "    max-width: 100% !important; }";
$email_temp .= "  .block-grid {";
$email_temp .= "    width: calc(100% - 40px) !important; }";
$email_temp .= "  .col {";
$email_temp .= "    width: 100% !important; }";
$email_temp .= "    .col > div {";
$email_temp .= "      margin: 0 auto; }";
$email_temp .= "  img.fullwidth {";
$email_temp .= "    max-width: 100% !important; } }";
$email_temp .= "    </style>";
$email_temp .= "</head>";
$email_temp .= "<!--[if mso]>";
$email_temp .= "<body class=\"mso-container\" style=\"background-color:#FFFFFF;\">";
$email_temp .= "<![endif]-->";
$email_temp .= "<!--[if !mso]><!-->";
$email_temp .= "<body class=\"clean-body\" style=\"margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #FFFFFF\">";
$email_temp .= "<!--<![endif]-->";
$email_temp .= "  <div class=\"nl-container\" style=\"min-width: 320px;Margin: 0 auto;background-color: #FFFFFF\">";
$email_temp .= "    <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color: #FFFFFF;\"><![endif]-->";

$email_temp .= "    <div style=\"background-color:#FFFFFF;\">";
$email_temp .= "      <div style=\"Margin: 0 auto;min-width: 320px;max-width: 500px;width: 500px;width: calc(19000% - 98300px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\" class=\"block-grid two-up\">";
$email_temp .= "        <div style=\"border-collapse: collapse;display: table;width: 100%;\">";
$email_temp .= "          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"background-color:#FFFFFF;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width: 500px;\"><tr class=\"layout-full-width\" style=\"background-color:transparent;\"><![endif]-->";

$email_temp .= "              <!--[if (mso)|(IE)]><td align=\"center\" width=\"250\" style=\" width:250px; padding-right: 0px; padding-left: 0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><![endif]-->";
$email_temp .= "            <div class=\"col num6\" style=\"Float: left;max-width: 320px;min-width: 250px;width: 250px;width: calc(35250px - 7000%);background-color: transparent;\">";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--><div style=\"border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\"><!--<![endif]-->";
$email_temp .= "                <div style=\"background-color: transparent; display: inline-block!important; width: 100% !important;\">";
$email_temp .= "                  <div style=\"Margin-top:20px; Margin-bottom:5px;\">";
$email_temp .= "<div align=\"center\" class=\"img-container center fullwidth\">";
$email_temp .= "<!--[if !mso]><!--><div style=\"Margin-right: 0px;Margin-left: 0px;\"><!--<![endif]-->";
$email_temp .= "  <!--[if mso]><table width=\"250\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right:  0px; padding-left: 0px;\" align=\"center\"><![endif]-->";
$email_temp .= "  <a href=\"https://beefree.io\" target=\"_blank\">";
$email_temp .= "    <img class=\"center fullwidth\" align=\"center\" border=\"0\" src=\"http://hopetracker.com/site/public/images/main/LOGO-1.jpg\" alt=\"Image\" title=\"Image\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block;border: none;height: auto;float: none;width: 100%;max-width: 250px\" width=\"250\">";
$email_temp .= "  </a>";
$email_temp .= "  <!--[if mso]></td></tr></table><![endif]-->";
$email_temp .= "<!--[if !mso]><!--></div><!--<![endif]-->";
$email_temp .= "</div>";
$email_temp .= "                  </div>";
$email_temp .= "                </div>";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->";
$email_temp .= "            </div>";
$email_temp .= "              <!--[if (mso)|(IE)]></td><td align=\"center\" width=\"250\" style=\" width:250px; padding-right: 0px; padding-left: 0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><![endif]-->";
$email_temp .= "            <div class=\"col num6\" style=\"Float: left;max-width: 320px;min-width: 250px;width: 250px;width: calc(35250px - 7000%);background-color: transparent;\">";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--><div style=\"border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\"><!--<![endif]-->";
$email_temp .= "                <div style=\"background-color: transparent; display: inline-block!important; width: 100% !important;\">";
$email_temp .= "                  <div style=\"Margin-top:20px; Margin-bottom:20px;\">";
$email_temp .= "<div></div>";
$email_temp .= "                  </div>";
$email_temp .= "                </div>";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->";
$email_temp .= "            </div>";
$email_temp .= "          <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->";
$email_temp .= "        </div>";
$email_temp .= "      </div>";
$email_temp .= "    </div>    <div style=\"background-color:#0068A5;\">";
$email_temp .= "      <div style=\"Margin: 0 auto;min-width: 320px;max-width: 500px;width: 500px;width: calc(19000% - 98300px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\" class=\"block-grid \">";
$email_temp .= "        <div style=\"border-collapse: collapse;display: table;width: 100%;\">";
$email_temp .= "          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"background-color:#0068A5;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width: 500px;\"><tr class=\"layout-full-width\" style=\"background-color:transparent;\"><![endif]-->";
$email_temp .= "              <!--[if (mso)|(IE)]><td align=\"center\" width=\"500\" style=\" width:500px; padding-right: 0px; padding-left: 0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><![endif]-->";
$email_temp .= "            <div class=\"col num12\" style=\"min-width: 320px;max-width: 500px;width: 500px;width: calc(18000% - 89500px);background-color: transparent;\">";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--><div style=\"border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\"><!--<![endif]-->";
$email_temp .= "                <div style=\"background-color: transparent; display: inline-block!important; width: 100% !important;\">";
$email_temp .= "                  <div style=\"Margin-top:0px; Margin-bottom:0px;\">";
$email_temp .= "<!--[if !mso]><!--><div align=\"center\" style=\"Margin-right: 10px;Margin-left: 10px;\"><!--<![endif]-->";
$email_temp .= "  <div style=\"line-height: 10px; font-size:1px\"> </div>";
$email_temp .= "  <!--[if (mso)|(IE)]><table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px;padding-left: 10px;\"><![endif]-->";
$email_temp .= "  <div style=\"border-top: 10px solid transparent; width:100%; font-size:1px;\"> </div>";
$email_temp .= "  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->";
$email_temp .= "  <div style=\"line-height:10px; font-size:1px\"> </div>";
$email_temp .= "<!--[if !mso]><!--></div><!--<![endif]-->";
$email_temp .= "<!--[if !mso]><!--><div style=\"Margin-right: 0px; Margin-left: 0px;\"><!--<![endif]-->";
$email_temp .= "  <div style=\"line-height: 30px; font-size: 1px\"> </div>";
$email_temp .= "  <!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px;\"><![endif]-->";
$email_temp .= "	<div style=\"font-size:12px;line-height:14px;color:#ffffff;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;\"><p style=\"margin: 0;font-size: 14px;line-height: 17px;text-align: center\"><strong><span style=\"font-size: 28px; line-height: 33px;\">Did you forget something?</span></strong></p></div>";

$email_temp .= "  <!--[if mso]></td></tr></table><![endif]-->";

$email_temp .= "  <div style=\"line-height: 30px; font-size: 1px\"> </div>";
$email_temp .= "<!--[if !mso]><!--></div><!--<![endif]-->";

$email_temp .= "<!--[if !mso]><!--><div style=\"Margin-right: 10px; Margin-left: 10px;\"><!--<![endif]-->";
$email_temp .= "  <div style=\"line-height: 10px; font-size: 1px\"> </div>";
$email_temp .= "  <!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px;\"><![endif]-->";

$email_temp .= "	<div style=\"font-size:12px;line-height:18px;color:#FFFFFF;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;\"><p style=\"margin: 0;font-size: 14px;line-height: 21px\">Hi,</p><p style=\"margin: 0;font-size: 14px;line-height: 21px\"> <br></p><p style=\"margin: 0;font-size: 14px;line-height: 21px\">Just click the button or copy and paste the link below into your browser to reset your password.</p><p style=\"margin: 0;font-size: 14px;line-height: 21px\"> </p><p style=\"margin: 0;font-size: 14px;line-height: 21px\">Link</p></div>";

$email_temp .= "  <!--[if mso]></td></tr></table><![endif]-->";

$email_temp .= "  <div style=\"line-height: 10px; font-size: 1px\"> </div>";
$email_temp .= "<!--[if !mso]><!--></div><!--<![endif]-->";


$email_temp .= "<!--[if !mso]><!--><div align=\"center\" style=\"Margin-right: 10px;Margin-left: 10px;\"><!--<![endif]-->";
$email_temp .= "  <div style=\"line-height: 10px; font-size:1px\"> </div>";
$email_temp .= "  <!--[if (mso)|(IE)]><table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px;padding-left: 10px;\"><![endif]-->";
$email_temp .= "  <div style=\"border-top: 10px solid transparent; width:100%; font-size:1px;\"> </div>";
$email_temp .= "  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->";
$email_temp .= "  <div style=\"line-height:10px; font-size:1px\"> </div>";
$email_temp .= "<!--[if !mso]><!--></div><!--<![endif]-->";

$email_temp .= "                  </div>";
$email_temp .= "                </div>";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->";
$email_temp .= "            </div>";
$email_temp .= "          <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->";
$email_temp .= "        </div>";
$email_temp .= "      </div>";
$email_temp .= "    </div>    <div style=\"background-color:#B9B9B9;\">";
$email_temp .= "      <div style=\"Margin: 0 auto;min-width: 320px;max-width: 500px;width: 500px;width: calc(19000% - 98300px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\" class=\"block-grid \">";
$email_temp .= "        <div style=\"border-collapse: collapse;display: table;width: 100%;\">";
$email_temp .= "          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"background-color:#B9B9B9;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width: 500px;\"><tr class=\"layout-full-width\" style=\"background-color:transparent;\"><![endif]-->";
$email_temp .= "              <!--[if (mso)|(IE)]><td align=\"center\" width=\"500\" style=\" width:500px; padding-right: 0px; padding-left: 0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><![endif]-->";
$email_temp .= "            <div class=\"col num12\" style=\"min-width: 320px;max-width: 500px;width: 500px;width: calc(18000% - 89500px);background-color: transparent;\">";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--><div style=\"border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\"><!--<![endif]-->";
$email_temp .= "                <div style=\"background-color: transparent; display: inline-block!important; width: 100% !important;\">";
$email_temp .= "                  <div style=\"Margin-top:30px; Margin-bottom:30px;\">";
$email_temp .= "<div align=\"center\" class=\"button-container center\" style=\"Margin-right: 10px;Margin-left: 10px;\">";
$email_temp .= "    <div style=\"line-height:15px;font-size:1px\"> </div>";
$email_temp .= "  <a href=\"http://hopetracker.com\" target=\"_blank\" style=\"color: #ffffff; text-decoration: none;\">";
$email_temp .= "    <!--[if mso]>";
$email_temp .= "      <v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://hopetracker.com\" style=\"height:42px; v-text-anchor:middle; width:218px;\" arcsize=\"60%\" strokecolor=\"#026493\" fillcolor=\"#026493\" >";
$email_temp .= "      <w:anchorlock/><center style=\"color:#ffffff; font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size:16px;\">";
$email_temp .= "    <![endif]-->";
$email_temp .= "    <!--[if !mso]><!-->";
$email_temp .= "    <div style=\"color: #ffffff; background-color: #026493; border-radius: 25px; -webkit-border-radius: 25px; -moz-border-radius: 25px; max-width: 198px; width: 40%; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; text-align: center;\">";
$email_temp .= "    <!--<![endif]-->";
$email_temp .= "      <span style=\"font-size:16px;line-height:32px;\"><span style=\"font-size: 14px; line-height: 28px;\" data-mce-style=\"font-size: 14px;\" mce-data-marked=\"1\">Reset Password</span></span>";
$email_temp .= "    <!--[if !mso]><!-->";
$email_temp .= "    </div>";
$email_temp .= "    <!--<![endif]-->";
$email_temp .= "    <!--[if mso]>";
$email_temp .= "          </center>";
$email_temp .= "      </v:roundrect>";
$email_temp .= "    <![endif]-->";
$email_temp .= "  </a>";
$email_temp .= "    <div style=\"line-height:10px;font-size:1px\"> </div>";
$email_temp .= "</div>";

$email_temp .= "<!--[if !mso]><!--><div style=\"Margin-right: 10px; Margin-left: 10px;\"><!--<![endif]-->";
$email_temp .= "  <!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px;\"><![endif]-->";

$email_temp .= "	<div style=\"font-size:12px;line-height:18px;color:#434343;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;\"><p style=\"margin: 0;font-size: 12px;line-height: 18px\">If you don't want to reset your password or if you didn't request this change, you can ignore this email.</p></div>";

$email_temp .= "  <!--[if mso]></td></tr></table><![endif]-->";
$email_temp .= "  <div style=\"line-height: 10px; font-size: 1px\"> </div>";
$email_temp .= "<!--[if !mso]><!--></div><!--<![endif]-->";

$email_temp .= "<!--[if !mso]><!--><div align=\"center\" style=\"Margin-right: 10px;Margin-left: 10px;\"><!--<![endif]-->";
$email_temp .= "  <div style=\"line-height: 10px; font-size:1px\"> </div>";
$email_temp .= "  <!--[if (mso)|(IE)]><table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px;padding-left: 10px;\"><![endif]-->";
$email_temp .= "  <div style=\"border-top: 0px solid transparent; width:100%; font-size:1px;\"> </div>";
$email_temp .= "  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->";
$email_temp .= "  <div style=\"line-height:10px; font-size:1px\"> </div>";
$email_temp .= "<!--[if !mso]><!--></div><!--<![endif]-->";

$email_temp .= "                  </div>";
$email_temp .= "                </div>";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->";
$email_temp .= "            </div>";
$email_temp .= "          <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->";
$email_temp .= "        </div>";
$email_temp .= "      </div>";
$email_temp .= "    </div>    <div style=\"background-color:#ffffff;\">";
$email_temp .= "      <div style=\"Margin: 0 auto;min-width: 320px;max-width: 500px;width: 500px;width: calc(19000% - 98300px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\" class=\"block-grid \">";
$email_temp .= "        <div style=\"border-collapse: collapse;display: table;width: 100%;\">";
$email_temp .= "          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"background-color:#ffffff;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width: 500px;\"><tr class=\"layout-full-width\" style=\"background-color:transparent;\"><![endif]-->";

$email_temp .= "              <!--[if (mso)|(IE)]><td align=\"center\" width=\"500\" style=\" width:500px; padding-right: 0px; padding-left: 0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><![endif]-->";
$email_temp .= "            <div class=\"col num12\" style=\"min-width: 320px;max-width: 500px;width: 500px;width: calc(18000% - 89500px);background-color: transparent;\">";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--><div style=\"border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\"><!--<![endif]-->";
$email_temp .= "                <div style=\"background-color: transparent; display: inline-block!important; width: 100% !important;\">";
$email_temp .= "                  <div style=\"Margin-top:30px; Margin-bottom:30px;\">";


$email_temp .= "<!--[if !mso]><!--><div style=\"Margin-right: 10px; Margin-left: 10px;\"><!--<![endif]-->";
$email_temp .= "  <div style=\"line-height: 15px; font-size: 1px\"> </div>";
$email_temp .= "  <!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px;\"><![endif]-->";

$email_temp .= "	<div style=\"font-size:12px;line-height:18px;color:#959595;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;text-align:left;\"><p style=\"margin: 0;font-size: 14px;line-height: 21px;text-align: center\">Copyright ©2017 HopeTracker. All Rights Reserved. <br></p></div>";

$email_temp .= "  <!--[if mso]></td></tr></table><![endif]-->";

$email_temp .= "  <div style=\"line-height: 10px; font-size: 1px\"> </div>";
$email_temp .= "<!--[if !mso]><!--></div><!--<![endif]-->";

$email_temp .= "                  </div>";
$email_temp .= "                </div>";
$email_temp .= "              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->";
$email_temp .= "            </div>";
$email_temp .= "          <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->";
$email_temp .= "        </div>";
$email_temp .= "      </div>";
$email_temp .= "    </div>   <!--[if (mso)|(IE)]></td></tr></table><![endif]-->";
$email_temp .= "  </div>";


$email_temp .= "</body></html>";
