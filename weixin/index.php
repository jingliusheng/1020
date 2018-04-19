<?php
require_once "jssdk.php";
error_reporting(E_ERROR);
$jssdk = new JSSDK("wxa962c595079a0a4c", "8713885b0b21eef383171fa3d3c0dec5");
$signPackage = $jssdk->GetSignPackage();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title></title>
        <style media="screen">
            * {
                margin: 0;
                padding: 0;
            }

            div.container {
                margin: 20px;
                height: 300px;
                display: flex;
                justify-content: space-around;;
                align-items: center;
            }
            div.btn {
                padding: 10px;
                border: 1px dashed blue;
                display: inline-block;
                background-color: rgb(109, 240, 165);
                color: white;
                border-radius: 5px;
            }
            div.btn:active {
                background-color: rgb(90, 150, 74);
            }


        </style>
    </head>
    <body>
        <h1>调用微信JS-SDK的功能</h1>
        <img id="head" src="" alt="" />
        <div class="container">
            <div class="btn take-photos">拍照</div>
            <div class="btn saoyisao">扫一扫</div>
            <div class="btn get-location">定位</div>
        </div>

    </body>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
    <script type="text/javascript">
        // JSSDK的配置
        wx.config({
          debug: true,
          appId: '<?php echo $signPackage["appId"];?>',
          timestamp: <?php echo $signPackage["timestamp"];?>,
          nonceStr: '<?php echo $signPackage["nonceStr"];?>',
          signature: '<?php echo $signPackage["signature"];?>',
          jsApiList: [
              'onMenuShareTimeline',
              'onMenuShareAppMessage',
              'onMenuShareQQ',
              'onMenuShareWeibo',
              'onMenuShareQZone',
              'startRecord',
              'stopRecord',
              'onVoiceRecordEnd',
              'playVoice',
              'pauseVoice',
              'stopVoice',
              'onVoicePlayEnd',
              'uploadVoice',
              'downloadVoice',
              'chooseImage',
              'previewImage',
              'uploadImage',
              'downloadImage',
              'translateVoice',
              'getNetworkType',
              'openLocation',
              'getLocation',
              'hideOptionMenu',
              'showOptionMenu',
              'hideMenuItems',
              'showMenuItems',
              'hideAllNonBaseMenuItem',
              'showAllNonBaseMenuItem',
              'closeWindow',
              'scanQRCode',
              'chooseWXPay',
              'openProductSpecificView',
              'addCard',
              'chooseCard',
              'openCard'
          ]
        });
        wx.ready(function () {
            // 在这里调用 API
            alert("成功了");

            var takePhotosBtn = document.querySelector(".take-photos");
            takePhotosBtn.addEventListener('click', function () {
                alert('点击了拍照');
                wx.chooseImage({
                    count: 1, // 默认9
                    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                        alert(localIds);

                        document.querySelector("#head").src = localIds.locallds[0];
                    }
                });
            });



            document.querySelector(".saoyisao").addEventListener('click', function () {
                wx.scanQRCode({
                    needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                    success: function (res) {
                        var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                        alert(result);
                    }
                });
            });


            document.querySelector(".get-location").addEventListener('click', function () {
                wx.getLocation({
                    type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                    success: function (res) {
                        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                        var speed = res.speed; // 速度，以米/每秒计
                        var accuracy = res.accuracy; // 位置精度
                        alert(res);
                    }
                });

            });


        });
        wx.error(function(res){
            // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            alert(res);
        });
    </script>
</html>
