/**
 * @auther DangChengcheng 请保留作者
 * @mailTo dc2002007@163.com
 */

var Step_Tool_dc =function(ClassName,callFun){
    this.ClassName=ClassName,
    this.callFun=callFun,
    this.Steps = new Array(),
    this.stepAllHtml="";

}
Step_Tool_dc.prototype={
    /**
     * 绘制到目标位置
     */
     createStepArray:function(currStep,stepListJson){
        this.currStep=currStep;

            for (var i=0; i<stepListJson.length;i++){
            var  Step_Obj =new Step( this.currStep,stepListJson[i].StepNum,stepListJson[i].StepText,stepListJson.length);

                Step_Obj.createStepHtml();
                this.Steps.push(Step_Obj);
            }

        },
    drawStep:function(currStep,stepListJson){
        this.clear();
        this.createStepArray(currStep,stepListJson);
        if(this.Steps.length>0){
        this.stepAllHtml+="<ul>";
        for (var i=0; i<this.Steps.length;i++){
            this.stepAllHtml+=this.Steps[i].htmlCode;
        }
        this.stepAllHtml+="</ul>";
        jQuery("."+this.ClassName).html(this.stepAllHtml);
            this.createEvent();
         } else{
            jQuery("."+this.ClassName).html("没有任何步骤");
        }
    },createEvent:function(){
        var self=this;
        jQuery("."+this.ClassName+" ul li a").click(function(){
            var num=jQuery(this).attr("data-value");
            alert(num);
            var text=jQuery(this).attr("data-text");
            result={value:num,text:text} ;
            eval(self.callFun+"(result)");
        });
    }
    ,clear:function(){
        this.Steps=new Array();
        jQuery("."+this.ClassName).html("");
        this.stepAllHtml="";
    }
}
var Step=function(currStep,StepNum,StepText,totalCount){
        this.currStep=currStep,
        this.StepNum=StepNum ,
        this.StepText=StepText,
        this.totalCount=totalCount,
        this.htmlCode="";
}
Step.prototype={
    createStepHtml:function(){
         var stepHtml="\<span\>"+this.StepNum+"\</span\>";
        stepHtml=stepHtml+"\<a href=\"#\"    data-value=\""+this.StepNum+"\" data-text=\""+this.StepText+"\" \>"+this.StepText+"\</a\>";
        if(this.currStep>this.totalCount){
            this.currStep=this.totalCount;
        }else if(this.currStep<=0){this.currStep=1;}

        if(this.currStep>this.StepNum&&this.StepNum==1){
            classSype="firstFinshStep";
        } else if(this.currStep==this.StepNum&&this.StepNum==1){
            classSype="firstFinshStep_curr1";
        }
       else if(this.currStep==this.StepNum&&this.currStep!=this.totalCount){//当前步骤,下一个未进行,并且不是最后一个
            classSype="coressStep";
        }else  if(this.currStep==this.StepNum&&this.StepNum==this.totalCount){//当前步骤 并且是最后一步
            classSype="finshlast";
        }else if(this.currStep<this.StepNum&&this.StepNum==this.totalCount){//未进行步骤,并且是最后一个
            classSype="last";
        } else if(this.currStep<this.StepNum){//未进行的步骤
            classSype="loadStep";
        } else if(this.currStep>this.StepNum){//已进行的步骤
            classSype="finshStep";
        }
        stepHtml="\<li class=\""+classSype+"\"\>"+stepHtml+"\</a\>";
        this.htmlCode=stepHtml;
    }

}


