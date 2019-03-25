window.onload=function(){
    $('.page1').on('touchmove',function(){
        page2Animate();
    });
    $('.page2-button').on('click',function(){
        page3Animate();
    });
    $('.page3-left').on('click',function(){
        changeLeft();
    });
    $('.page3-right').on('click',function(){
        changeRight();
    });
    $('.page3-mid').on('click',function(){
        $('.page3-file').click();
    });
    document.querySelector('.page3-file').addEventListener('change', function () {
        lrz(this.files[0])
            .then(function (rst) {
                uploadPic(rst);
            })
            .catch(function (err) {
                alert('上传失败');
            })
    });
    $('.page3-button').on('click',function(){
        page4Animate();
    });
    $('.page4-words li').on('click',function(){
        wordN = $(this).index();
        openView();
    });
    $('.view-back').on('click',function(){
        closeView();
    });
    $('.view-check').on('click',function(){
        $('.page4-words li').removeClass('checked');
        $('.page4-words li').eq(wordN).addClass('checked');
        canvasWord = $('.page4-view-content').html();
        $('.page4-upload').val('');
        closeView();
    });
    $('.page4-upload').on('propertychange input',function(){
        $('.page4-words li').removeClass('checked');
        canvasWord = $('.page4-upload').val();
    });
    $('.page4-button').on('click',function(){
        if(!canvasWord){
            alert('请选择或输入心情');
            return;
        }
        makeCard();
    });

    $('.page5-collect').on('click',function(){
        openCollect();
    });
    $('.collect').on('click',function(){
        closeCollect();
    });
    $('.page5-share').on('click',function(){
        openShare();
    });
    $('.share').on('click',function(){
        closeShare();
    });

};

document.addEventListener('touchmove',function(e){
    e.preventDefault();
}, false);




var picN = 0;
var wordN = 0;
var canChange = true;
var canvasBg = new Image();
var canvasWord = '';
var weatherIcon = new Image();
weatherIcon.src = weatherIconsrc;
var logo = new Image();
logo.src = logosrc;
var canvasActive = new Image();
canvasActive.src = activeSrc;
var cardSrc = '';
var nameIcon = new Image();
nameIcon.src = namesrc;
var qr = new Image();
qr.src = qrsrc;
var icon = new Image();
icon.src = localsrc;


var animationend = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

function page1Animate(){
    $('.page1 .bg').removeClass('hidden').addClass('animated infinite zoomShow');
    $('.page1 .logo').removeClass('hidden').addClass('animated slideInDown').one(animationend,function(){
        $('.page1-title').removeClass('hidden').addClass('animated fadeInDown').one(animationend,function(){
            $('.page1-arrow').removeClass('hidden').addClass('animated infinite fadeInUp');
        });
    });
}

function page2Animate(){
    $('.page1').addClass('animated fadeOut');
    $('.page2').removeClass('hidden').addClass('animated fadeIn').one(animationend,function(){
        $('.page1').removeClass('animated fadeOut').addClass('hidden');
        $('.page2').removeClass('animated fadeIn');
        $('.page2-pic img').eq(0).removeClass('hidden').addClass('animated delay1 slideInLeft');
        $('.page2-pic img').eq(1).removeClass('hidden').addClass('animated delay2 slideInLeft');
        $('.page2-pic img').eq(2).removeClass('hidden').addClass('animated delay3 slideInLeft').one(animationend,function(){
            $('.page2-notice').removeClass('hidden').addClass('animated flipInX').one(animationend,function(){
                $('.page2-button').removeClass('hidden').addClass('animated zoomIn');
            });
        });
    });
}


function page3Animate(){
    $('.page2').addClass('animated fadeOut');
    $('.page3').removeClass('hidden').addClass('animated fadeIn').one(animationend,function(){
        $('.page2').removeClass('animated fadeOut').addClass('hidden');
        $('.page3').removeClass('animated fadeIn');
        $('.page3 .logo').removeClass('hidden').addClass('animated slideInDown').one(animationend,function(){
            $('.page3-title').removeClass('hidden').addClass('animated fadeInDown').one(animationend,function(){
                $('.page3-box li').eq(0).removeClass('hidden');
                $('.page3-box').removeClass('hidden').addClass('animated bounceInDown').one(animationend,function(){
                    $('.page3-button').removeClass('hidden').addClass('animated zoomIn').one(animationend,function(){
                        $('.page3-upload').addClass('shortAnimated fadeOut').one(animationend,function(){
                            $('.page3-upload').removeClass('shortAnimated fadeOut').addClass('hidden');
                            canvasBg.src = $('.page3-pic').eq(0).attr('src');
                        });
                    });
                });
            });
        });
    });
}

function page4Animate(){
    $('.page3').addClass('animated fadeOut');
    $('.page4').removeClass('hidden').addClass('animated fadeIn').one(animationend,function(){
        $('.page3').removeClass('animated fadeOut').addClass('hidden');
        $('.page4').removeClass('animated fadeIn');
        var canvas = document.getElementById('card');
        canvas.setAttribute('width',640);
        canvas.setAttribute('height',960);
        $('.page4 .logo').removeClass('hidden').addClass('animated slideInDown').one(animationend,function(){
            $('.page4-title').removeClass('hidden').addClass('animated fadeInDown').one(animationend,function(){
                $('.page4-words li').eq(0).removeClass('hidden').addClass('animated delay1 slideInLeft');
                $('.page4-words li').eq(1).removeClass('hidden').addClass('animated delay2 slideInLeft');
                $('.page4-words li').eq(2).removeClass('hidden').addClass('animated delay3 slideInLeft');
                $('.page4-words li').eq(3).removeClass('hidden').addClass('animated delay4 slideInLeft').one(animationend,function(){
                    $('.page4-or').removeClass('hidden').addClass('animated flipInX').one(animationend,function(){
                        $('.page4-upload').removeClass('hidden').addClass('animated fadeInUp').one(animationend,function(){
                            $('.page4-button').removeClass('hidden').addClass('animated zoomIn');
                        });
                    });
                });
            });
        });
    });
}

function page5Animate(){
    $('.page4').addClass('animated fadeOut');
    $('.page5').removeClass('hidden').addClass('animated fadeIn').one(animationend,function(){
        $('.page4').removeClass('animated fadeOut').addClass('hidden');
        $('.page5').removeClass('animated fadeIn');
        $('.page5-card').removeClass('hidden').addClass('animated bounceInDown').one(animationend,function(){
            $('.page5-button').removeClass('hidden').addClass('animated zoomIn');
        });
    });
}







function changeLeft(){
    if(picN == 0){
        return;
    }
    if(!canChange){
        return;
    }
    if(!$('.page3-upload').hasClass('hidden')){
        $('.page3-upload').addClass('shortAnimated fadeOut').one(animationend,function(){
            $('.page3-upload').removeClass('shortAnimated fadeOut').addClass('hidden');
        });
        canvasBg.src = $('.page3-pic').eq(picN).attr('src');
        return;
    }
    canChange = false;
    $('.page3-box li').eq(picN).addClass('shortAnimated fadeOutLeft').one(animationend,function(){
        $('.page3-box li').eq(picN).removeClass('shortAnimated fadeOutLeft').addClass('hidden');
        $('.page3-box li').eq(picN-1).removeClass('hidden').addClass('shortAnimated fadeInRight').one(animationend,function(){
            $('.page3-box li').eq(picN-1).removeClass('shortAnimated fadeInRight');
            picN = picN-1;
            canvasBg.src = $('.page3-pic').eq(picN).attr('src');
            canChange = true;
        });
    });
}

function changeRight(){
    if(picN == $('.page3-pic').length-1){
        return;
    }
    if(!canChange){
        return;
    }
    if(!$('.page3-upload').hasClass('hidden')){
        $('.page3-upload').addClass('shortAnimated fadeOut').one(animationend,function(){
            $('.page3-upload').removeClass('shortAnimated fadeOut').addClass('hidden');
        });
        canvasBg.src = $('.page3-pic').eq(picN).attr('src');
        return;
    }
    canChange = false;
    $('.page3-box li').eq(picN).addClass('shortAnimated fadeOutRight').one(animationend,function(){
        $('.page3-box li').eq(picN).removeClass('shortAnimated fadeOutRight').addClass('hidden');
        $('.page3-box li').eq(picN+1).removeClass('hidden').addClass('shortAnimated fadeInLeft').one(animationend,function(){
            $('.page3-box li').eq(picN+1).removeClass('shortAnimated fadeInLeft');
            picN++;
            canvasBg.src = $('.page3-pic').eq(picN).attr('src');
            canChange = true;
        });
    });
}

function uploadPic(rst){
    $('.page3-upload').removeClass('hidden');
    canvasBg.src = rst.base64;
    $('.page3-upload-pic').attr('src',rst.base64);
}


function openView(){
    $('.page4-view-content').html($('.page4-words li').eq(wordN).html());
    $('.page4-mask').removeClass('hidden').addClass('animated fadeIn').one(animationend,function(){
        $('.page4-mask').removeClass('animated fadeIn');
    });
}

function closeView(){
    $('.page4-mask').addClass('animated fadeOut').one(animationend,function(){
        $('.page4-mask').removeClass('animated fadeOut').addClass('hidden');
    });
}

function makeCard(){
    $('.notice').removeClass('hidden');
    var canvas = document.getElementById('card');
    var ctx = canvas.getContext('2d');
    var cw = $('#card').width();
    var ch = $('#card').height();
    if(cw/ch<canvasBg.width/canvasBg.height){
        ctx.drawImage(canvasBg,(cw-ch*canvasBg.width/canvasBg.height)/2,0,ch*canvasBg.width/canvasBg.height,ch);
    }
    else{
        ctx.drawImage(canvasBg,0,(ch-cw*canvasBg.height/canvasBg.width)/2,cw,cw*canvasBg.height/canvasBg.width);
    }

    ctx.fillStyle = 'rgba(0,0,0,0.2)';
    ctx.fillRect(0,0,cw,ch);

    ctx.drawImage(logo,0.85*cw-0.05*cw,0.05*cw,0.15*cw,0.15*cw*logo.height/logo.width);

    var cMonth = new Date().getMonth()+1<10?'0'+(new Date().getMonth()+1):new Date().getMonth()+1;
    var cDate = new Date().getDate()<10?'0'+new Date().getDate():new Date().getDate();
    var cDay = new Date().getDay();
    var cDays = ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'];
    ctx.fillStyle="#ffffff";
    ctx.strokeStyle="#ffffff";
    ctx.textAlign = 'left';
    ctx.lineWidth = '1';

    ctx.font = 'bold 80px Arial';
    ctx.fillText(cMonth,0.05*cw,0.05*cw+70);
    ctx.fillText(cDate,0.05*cw+140,0.05*cw+70);

    ctx.font = '40px Arial';
    ctx.fillText('月',0.05*cw+95,0.05*cw+65);
    ctx.fillText('日',0.05*cw+230,0.05*cw+65);

    ctx.font = '24px Arial';
    ctx.fillText(cDays[cDay],0.05*cw+235,0.05*cw+20);

    ctx.beginPath();
    ctx.moveTo(0.05*cw,0.05*cw+90);
    ctx.lineTo(0.05*cw+265,0.05*cw+90);
    ctx.stroke();

    ctx.drawImage(weatherIcon,0.05*cw,0.05*cw+95,120,120);

    ctx.font = '32px Arial';
    ctx.fillText(temperature,0.05*cw+140,0.05*cw+130);

    ctx.fillText(weather,0.05*cw+140,0.05*cw+165);

    ctx.drawImage(icon,0.05*cw+140,0.05*cw+178,25,25);

    ctx.font = 'bold 24px Arial';

    ctx.fillText(city,0.05*cw+170,0.05*cw+200);


    if(type == 1){
        ctx.font = '24px Arial';

        var row = canvasWord.length/10;
        if(!canvasWord.length%10==0){
            row = row+1;
        }
        var wordArr = [];
        for(var i=0;i<row;i++){
            wordArr[i] = canvasWord.slice(0+10*i,10+10*i);
            ctx.fillText(wordArr[i],0.05*cw,0.88*ch+40*i);
        }

        ctx.drawImage(nameIcon,0.05*cw,0.88*ch-80,40,40);

        ctx.font = '30px Arial';

        ctx.fillText(username,0.05*cw+50,0.88*ch-50);

        ctx.drawImage(qr,0.8*cw-0.05*cw,ch-0.05*cw-0.2*cw*qr.height/qr.width,0.2*cw,0.2*cw*qr.height/qr.width);
    }
    else if(type == 2){
        ctx.font = '24px Arial';

        var row = canvasWord.length/10;
        if(!canvasWord.length%10==0){
            row = row+1;
        }
        var wordArr = [];
        for(var i=0;i<row;i++){
            wordArr[i] = canvasWord.slice(0+10*i,10+10*i);
            ctx.fillText(wordArr[i],0.05*cw,0.6*ch+40*i);
        }

        ctx.drawImage(nameIcon,0.05*cw,0.6*ch-80,40,40);

        ctx.font = '30px Arial';

        ctx.fillText(username,0.05*cw+50,0.6*ch-50);

        ctx.drawImage(canvasActive,0,ch-canvasActive.height,cw,canvasActive.height);

        ctx.drawImage(qr,0.75*cw,0.6*ch-80,0.25*cw,0.25*cw*qr.height/qr.width);
    }


    cardSrc = canvas.toDataURL('image/jpg');
    $('.page5-card').attr('src',cardSrc);
    page5Animate();
    $('.notice').addClass('hidden');
    $.ajax({url: doneurl});
};


function openCollect(){
    $('.collect').removeClass('hidden').addClass('animated fadeIn').one(animationend,function(){
        $('.collect').removeClass('animated fadeIn');
    });
}

function closeCollect(){
    $('.collect').addClass('animated fadeOut').one(animationend,function(){
        $('.collect').removeClass('animated fadeOut').addClass('hidden');
    });
}


function openShare(){
    $('.share').removeClass('hidden').addClass('animated fadeIn').one(animationend,function(){
        $('.share').removeClass('animated fadeIn');
    });
}

function closeShare(){
    $('.share').addClass('animated fadeOut').one(animationend,function(){
        $('.share').removeClass('animated fadeOut').addClass('hidden');
    });
}