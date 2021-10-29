<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
        /* Base */

     </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table style="width: 600px; margin: 0 auto; border: solid 1px rgba(51,51,53,0.1); border-radius:10px;" class="content" width="100%" cellpadding="0" cellspacing="0">
                     <!-- ***********************************************************
                        header
                      *********************************************************** -->
                    <thead style="text-align:center !important;  border-bottom: solid 1px rgba(51, 51, 53, 0.1); padding:15px; display:inline-table; width:570px; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <tr>
                                <th>
                                         <a href="{{ $url }}" style="text-transform: uppercase; color: #fff; text-decoration: inherit;"> 
                                         <img style="margin-right:15px;" src="http://test1.rettest.com/perception_mapping/images/logo.png"/>
                                         {{-- <span style="font-weight: 400;">{{ config('app.name') }}</span> --}}
                                        </a>
                                </th>
                            </tr>
                    </thead>
                  

                        <tbody >
                                 <tr>
                                    <td class="content-cell" style="background:#fff; padding:20px;">
                                      
                                           {!! $maincontent !!}
                                      
                                    </td>
                                </tr>
                        </tbody>
                    <!-- ***********************************************************
                        footer
                    *********************************************************** -->
                    <tfoot style="text-align:center !important; padding:10px; display:inline-table; border-top: solid 1px rgba(51, 51, 53, 0.1);  width:580px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <tr>
                                <td>
                                    <span style="color:#000; font-size: 14px; font-weight: 400;">  © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')</span>
                                </td>
                            </tr>
                    </tfoot>
                    <!-- ***********************************************************
                        footer end
                    *********************************************************** -->


                </table>
            </td>
        </tr>
    </table>
</body>
</html>