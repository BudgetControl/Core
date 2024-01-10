@extends('layouts.base')

@section('content')

<style>
    .progress-bar {
  width: 100%;
  background-color: #e0e0e0;
  border-radius: 5px;
  height: 20px;
  position: relative;
}

.progress {
  width: {{$percentage}}%; /* Set this dynamically based on the progress */
  height: 100%;
  background-color: red; /* Set your desired progress color */
  border-radius: 5px;
}
</style>

<table id="u_content_text_3" style="font-family:'Raleway',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
    <tbody>
        <tr>
            <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:20px 50px 50px;font-family:'Raleway',sans-serif;" align="left">
                <div class="v-text-align" align="left">
                    <p>Hello {{$user_name}},</p>
                    
                    <p>I hope this email finds you well. We appreciate your trust in for managing your finances.</p>
                    <p>We wanted to bring to your attention that one of your budgets has recently expired. It's an essential part of financial planning to ensure that your budget remains up-to-date to meet your financial goals effectively.</p>

                    <p><b>Budget Name:</b> {{$budget_name}}</p>
                    <p><b>Excess:</b> {{$percentage}}%</p>
                    <p><b>Remaining:</b> {{$difference}}</p>
                    
                    <div class="progress-bar" id="budgetProgressBar">
                        <div class="progress" id="progress"></div>
                    </div>

                    <p>To continue benefiting from our budgeting features and stay on top of your financial game, we recommend reviewing and updating your budget at your earliest convenience.</p>

                    <p>Updating your budget ensures that you have the most accurate insights into your finances, helping you make informed decisions and stay on track toward your financial objectives.</p>

                    <p>If you have any questions or need assistance, feel free to reach out to our support team at [Your Support Email or Contact Information]. We're here to help you make the most of your financial journey.</p>

                    <p>Best regards,</p>
                    <p>The Budget Control Team</p>
                    <!--[if mso]>
    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="" style="height:37px; v-text-anchor:middle; width:162px;" arcsize="0%"  stroke="f" fillcolor="#047183"><w:anchorlock/><center style="color:#FFFFFF;">
    <![endif]-->
                    
                    <!--[if mso]></center></v:roundrect><![endif]-->
                </div>

            </td>
        </tr>
    </tbody>
</table>

<!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td><![endif]-->
<!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>



<div class="u-row-container" style="padding: 0px;background-color: transparent">
    <div class="u-row" style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
        <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
            <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px;"><tr style="background-color: transparent;"><![endif]-->

            <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color: #ffffff;width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]-->
            <div class="u-col u-col-100" style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                <div style="background-color: #ffffff;height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
                    <!--[if (!mso)&(!IE)]><!-->
                    <div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]-->

                        <table id="u_content_social_1" style="font-family:'Raleway',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                            <tbody>
                                <tr>
                                    <td class="v-container-padding-padding" style="overflow-wrap:break-word;word-break:break-word;padding:50px 10px 10px;font-family:'Raleway',sans-serif;" align="left">

                                        <div align="center">
                                            <div style="display: table; max-width:167px;">
                                                <!--[if (mso)|(IE)]><table width="167" cellpadding="0" cellspacing="0" border="0"><tr><td style="border-collapse:collapse;" align="center"><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace: 0pt;mso-table-rspace: 0pt; width:167px;"><tr><![endif]-->


                                                <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 10px;" valign="top"><![endif]-->
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 10px">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                <a href="https://www.facebook.com/unlayer" title="Facebook" target="_blank">
                                                                    <img src="images/image-2.png" alt="Facebook" title="Facebook" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if (mso)|(IE)]></td><![endif]-->

                                                <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 10px;" valign="top"><![endif]-->
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 10px">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                <a href="https://twitter.com/unlayerapp" title="Twitter" target="_blank">
                                                                    <img src="images/image-1.png" alt="Twitter" title="Twitter" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if (mso)|(IE)]></td><![endif]-->

                                                <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 10px;" valign="top"><![endif]-->
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 10px">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                <a href="https://www.linkedin.com/company/unlayer/mycompany/" title="LinkedIn" target="_blank">
                                                                    <img src="images/image-3.png" alt="LinkedIn" title="LinkedIn" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if (mso)|(IE)]></td><![endif]-->

                                                <!--[if (mso)|(IE)]><td width="32" style="width:32px; padding-right: 0px;" valign="top"><![endif]-->
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="32" height="32" style="width: 32px !important;height: 32px !important;display: inline-block;border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;margin-right: 0px">
                                                    <tbody>
                                                        <tr style="vertical-align: top">
                                                            <td align="left" valign="middle" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                                                                <a href="https://www.instagram.com/unlayer_official/" title="Instagram" target="_blank">
                                                                    <img src="images/image-4.png" alt="Instagram" title="Instagram" width="32" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;max-width: 32px !important">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if (mso)|(IE)]></td><![endif]-->


                                                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @endsection

                        @push('js')
                        //Enter your js code here
                        @endpush