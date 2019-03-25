// 单图片
function picture(container,type,picturename,empt){//container为canvas的id;type为生成图片的文件类型,picturename为下载的文件名
		
         setTimeout(function(){
                        var canvas = document.createElement("canvas"),
                            w=$('#'+container).width(),
                            h=$('#'+container).height();
                        canvas.width = w * 2;
                        canvas.height = h * 2;
                        canvas.style.width = w + "px";
                        canvas.style.height = h + "px";
                        var context = canvas.getContext("2d");//然后将画布缩放，将图像放大两倍画到画布上

                        context.scale(2,2);
                        html2canvas(document.getElementById(container), {
                            allowTaint: false,
                            taintTest: true,
                            canvas: canvas,
                            onrendered: function(canvas) {
                                canvas.id = "mycanvas";
                                canvas.style.display = 'none';
                                document.body.appendChild(canvas);
                                //生成base64图片数据
                                //var type="jpeg"
                                imgData = canvas.toDataURL(type,0.2);
                                //var newImg = document.createElement("img");
                                //newImg.src =  dataUrl;
                                //document.body.appendChild(newImg);
                                //console.log(imgData);
 
                                var _fixType = function(type) {
                                    type = type.toLowerCase().replace(/jpg/i, 'jpeg');
                                    var r = type.match(/png|jpeg|bmp|gif/)[0];
                                    return 'image/' + r;
                                };
                                // 加工image data，替换mime type
                                imgData = imgData.replace(_fixType(type),'image/octet-stream');
                               
                                /**
                                 * 在本地进行文件保存
                                 * @param  {String} data     要保存到本地的图片数据
                                 * @param  {String} filename 文件名
                                 */
                                var saveFile = function(data, filename){
                                    var save_link = document.createElementNS('http://www.w3.org/1999/xhtml', 'a');
                                    save_link.href = data;
                                    save_link.download = filename;
 
                                    var event = document.createEvent('MouseEvents');
                                    event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                                    save_link.dispatchEvent(event);
                                };
 
                                // 下载后的问题名
                                var filename =picturename + '.' + type;
                                // download
                                sizepicture(empt,imgData,function(res,datar){
                                    if(res==400){
                                      saveFile(datar,filename);
                                    }
                                })
                              
                               // that.dwtpdata=[]
                            },
                            width:1512,
                            height:15000
                        })
                    },2500)

	}
    function sizepicture(empt,base64data,relt){
  
    var img = new Image();
    img.src = base64data;
                img.onload = function() {
                    var that = this;
                    //生成比例
                    var w = empt.sizewidth
                        h = empt.sizeheight
            //             scale = w / h;
            //             w = wid || w;
            //             h = w / scale;
            //生成canvas
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                $(canvas).attr({
                    width: w,
                    height: h
                });
                ctx.drawImage(that, 0, 0, w, h);
                // 生成base64            
                base64 = canvas.toDataURL('image/jpeg');
           relt(400,base64)
            };
    }
    // 多图片
function pictureallr(container,type,picturename,that,relt=200){//container为canvas的id;type为生成图片的文件类型,picturename为下载的文件名
 
                        var canvas = document.createElement("canvas"),
                            w=$('#'+container).width(),
                            h=$('#'+container).height();
                        canvas.width = w * 2;
                        canvas.height = h * 2;
                        canvas.style.width = w + "px";
                        canvas.style.height = h + "px";
                        var context = canvas.getContext("2d");//然后将画布缩放，将图像放大两倍画到画布上
                        context.scale(2,2);

                        html2canvas(document.getElementById(container), {
                            allowTaint: false,
                            taintTest: true,
                            canvas: canvas,
                            onrendered: function(canvas) {
                                canvas.id = "mycanvas";
                                canvas.style.display = 'none';
                                document.body.appendChild(canvas);
                                //生成base64图片数据
                                //var type="jpeg"
                                imgData = canvas.toDataURL(type);
                                //var newImg = document.createElement("img");
                                //newImg.src =  dataUrl;
                                //document.body.appendChild(newImg);
                                //console.log(imgData);
 
                                var _fixType = function(type) {
                                    type = type.toLowerCase().replace(/jpg/i, 'jpeg');
                                    var r = type.match(/png|jpeg|bmp|gif/)[0];
                                    return 'image/' + r;
                                };
                                // 加工image data，替换mime type
                                imgData = imgData.replace(_fixType(type),'image/octet-stream');
                                /**
                                 * 在本地进行文件保存
                                 * @param  {String} data     要保存到本地的图片数据
                                 * @param  {String} filename 文件名
                                 */
                                var saveFile = function(data, filename){
                                    var save_link = document.createElementNS('http://www.w3.org/1999/xhtml', 'a');
                                    save_link.href = data;
                                    save_link.download = filename;
 
                                    var event = document.createEvent('MouseEvents');
                                    event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                                    save_link.dispatchEvent(event);
                                };
 
                                // 下载后的问题名

                                var filename =picturename + '.' + type;
                                // download
                               // saveFile(imgData,filename);
                                // savepictureall:base64
                                 sizepicture(that,imgData,function(res,datar){
                                    if(res==400){
                                        that.savepictureall.push(datar.substring(22));
                                        that.savepictureallname.push(picturename);
                                         if(that.savepictureall.length==that.goodsdata.length){
                                            that.picturezip()
                                          }
                                    }
                                })
                                
                                   relt(400)
                            },
                            width:1512,
                            height:15000
                        })

                       

    }
function datamatching(data,datas,that,relt=200){//data真实数据,datas模板数据
    console.log(data);
    // 店铺名片
    if(datas['type']==1){
        var templatedata2=datas;
         var templatedata3= JSON.stringify(templatedata2);
        var templatedataall=JSON.parse(templatedata3);
        var templatedata=templatedataall['datas'];
        for (var i = templatedata.length - 1; i >= 0; i--) {
            var width=templatedata[i]['width']
             var height=templatedata[i]['height']
            if( templatedata[i].string=="店铺名称"){
                templatedata[i].string=data.name;
            }
            if( templatedata[i].string=="店铺地址"){
                templatedata[i].string=data.address;
            }
             if( templatedata[i].string=="店铺电话"){
                templatedata[i].string=data.phone;
            }
             if( templatedata[i].string=="storecode"){
                templatedata[i].string="<img src='"+data.qrcode.base64+"' style='width:"+width+";height:"+height+"' >";
            }
            if( templatedata[i].string=="storelogo"){
                templatedata[i].string="<img src='"+that.attachurl+data.logo+"' style='width:"+width+";height:"+height+"' >";
             templatedata[i].string= templatedata[i].string.replace("\"","").replace("\"","");
            }
        }
        templatedataall['datas']=templatedata
        that.dwtpdata=templatedataall
         relt(400)
    }
    // 商品二维码
    if(datas['type']==2){
        var templatedata2=datas;
        var templatedata3= JSON.stringify(templatedata2);
        var templatedataall=JSON.parse(templatedata3);
        var templatedata=templatedataall['datas'];
        for (var i = templatedata.length - 1; i >= 0; i--) {
             var width=templatedata[i]['width']
             var height=templatedata[i]['height']
            if( templatedata[i].string=="商品价格"){
                templatedata[i].string=data['price'];
            }
            if( templatedata[i].string=="商品名称"){
                templatedata[i].string=data['name'];
            }
             if( templatedata[i].string=="goodcode"){
                templatedata[i].string="<img src='"+data.qrcode.base64+"' style='width:"+width+";height:"+height+"' >";
           
            }
            if( templatedata[i].string=="goodpicture"){
                templatedata[i].string="<img src='"+that.attachurl+data['picture']+"' style='width:"+width+";height:"+height+"' >";
            templatedata[i]['string']=templatedata[i]['string'].replace("\"","").replace("\"","");
            }
        }
          templatedataall['datas']=templatedata
         that.dwtpdata=templatedataall
         relt(400)
    }
    // 价格标签
    if(datas['type']==3){
        var templatedata2=datas;
        var templatedata3= JSON.stringify(templatedata2);
        var templatedataall=JSON.parse(templatedata3);
        var templatedata=templatedataall['datas'];
        for (var i = templatedata.length - 1; i >= 0; i--) {
            var width=templatedata[i]['width']
             var height=templatedata[i]['height']
            if( templatedata[i].string=="商品价格"){
                templatedata[i].string=data.price;
            }
            if( templatedata[i].string=="商品名称"){
                templatedata[i].string=data.name;
            }
             if( templatedata[i].string=="商品原价"){
                templatedata[i].string=data.price0;
            }
             if( templatedata[i].string=="商品现价"){
                //templatedata[i].string=data.pricepresentprice;
            }
             if( templatedata[i].string=="pricecode"){
              templatedata[i].string="<img src='"+data.qrcode.base64+"' style='width:"+width+";height:"+height+"' >";
           
            }
            if( templatedata[i].string=="pricepicture"){
                templatedata[i].string="<img src='"+that.attachurl+data.picture+"' style='width:"+width+";height:"+height+"' >";
            }

        }
       templatedataall['datas']=templatedata
        that.dwtpdata=templatedataall
         relt(400)
    }
     // 出货单
    if(datas['type']==4){
        var templatedata2=datas;
        var templatedata3= JSON.stringify(templatedata2);
        var templatedataall=JSON.parse(templatedata3);
        var templatedata=templatedataall['datas'];
        for (var i = templatedata.length - 1; i >= 0; i--) {
             var width=templatedata[i]['width']
             var height=templatedata[i]['height']
            if( templatedata[i].string=="支付方式"){
                if(data.pay_way==1){
                    templatedata[i].string="微信支付";
                }
                if(data.pay_way==2){
                    templatedata[i].string="货到付款";
                }
            }
            if( templatedata[i].string=="收件人"){
                templatedata[i].string=data.contact;
            }
            if( templatedata[i].string=="收件人电话"){
                templatedata[i].string=data.mobile;
            }
             if( templatedata[i].string=="收件省份"){
                templatedata[i].string=data.province;
            }
             if( templatedata[i].string=="收件人城市"){
                templatedata[i].string=data.city;
            }
             if( templatedata[i].string=="收件人区域"){
                templatedata[i].string=data.county;
            }
             if( templatedata[i].string=="收件人详细地址"){
                templatedata[i].string=data.street;
            }
             if( templatedata[i].string=="买家昵称"){
                templatedata[i].string=data.nickname;
            }
             if( templatedata[i].string=="买家备注"){
                templatedata[i].string=data.remark;
            }
            if( templatedata[i].string=="店铺名称"){
                templatedata[i].string=that.shop.name;
            }
             if( templatedata[i].string=="商品名称"){
                var a=data['orderdetail'];
                var name=[];
                for (var i2 = a.length - 1; i2 >= 0; i2--) {
                    name.push(a[i2].goodsname);
                   
                }
                templatedata[i].string=[];
                templatedata[i].string=name;
            }
             if( templatedata[i].string=="商品编号"){
               var a=data['orderdetail'];
               var name=[];
                for (var i2 = a.length - 1; i2 >= 0; i2--) {
                    name.push(a[i2].number);
                   
                }
                templatedata[i].string=[];
                templatedata[i].string=name;
            }
             if( templatedata[i].string=="商品价格"){
                var a=data['orderdetail'];
                var name=[];
                for (var i2 = a.length - 1; i2 >= 0; i2--) {
                    name.push(a[i2].price);
                   
                }
                templatedata[i].string=[];
                templatedata[i].string=name;
            }
            if( templatedata[i].string=="pricepicture"){
                templatedata[i].string="<img src='"+that.attachurl+data.picture+"' style='width:"+width+";height:"+height+"' >";
            }

        }
        console.log(templatedata);
       templatedataall['datas']=templatedata
        that.dwtpdata=templatedataall
         relt(400)
    }
    
    
}