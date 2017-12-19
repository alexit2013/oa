<extend name="Layout/ins_popup" />
<block name="content">
<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
    <div class="jumbotron">
  <h1><?php if(isset($message)) {?>
    <p class="success"><span class="glyphicon glyphicon-ok" aria-hidden="true"><?php echo($message); ?></span> </p>
    <?php }else{?>
    <p class="error"><span class="glyphicon glyphicon-remove" aria-hidden="true"><?php echo($error); ?></span></p>
    <?php }?></h1>
  <p> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b></p>
  <p><a class="btn btn-primary btn-lg" id="href" href="<?php echo($jumpUrl); ?>" role="button">如果你的浏览器没有自动跳转，请点击这里...</a></p>
<!-- <p><a class="btn btn-primary btn-lg" id="href" href="http://www.smeoa.com/" role="button">问题反馈-官方主页</a></p> -->
</div>
    </div>

   

</body>
</block>
<block name="js">
   <script type="text/javascript">
    (function(){
    var wait = document.getElementById('wait'),href = document.getElementById('href').href;

    var interval = setInterval(function(){
    var time = --wait.innerHTML;
    if(time <= 0) {
    location.href = href;
    clearInterval(interval);
    };
    }, 1000);
    })();
    </script>
</block>
