(function(BpmnModeler) {
  var bpmnModeler = new BpmnModeler({
    container: '#canvas'
  });
  function importXML(xml) {
    bpmnModeler.importXML(xml, function(err) {
      if (err) {
        return console.error('could not import BPMN 2.0 diagram', err);
      }
      var canvas = bpmnModeler.get('canvas');
      canvas.zoom('fit-viewport');
    });


    var saveButton = document.querySelector('#save-button');
    saveButton.addEventListener('click', function() {
      bpmnModeler.saveXML({ format: true }, function(err, xml) {
        if (err) {
          alert("未知错误");
        } else {
          console.info(xml);
          $.post(url,{xml:xml,who_list:who_list,form_list:form_list,who_type:who_type,line_form_list:line_form_list},function (response){
            layui.layer.msg(response.msg,{icon: response.code});
            setTimeout(function(){
              if(response.code==1){
                parent.location.reload();
              }
            },1000);
          },"json");
        }
      });
    });
  }
  //默认流程
  var diagramXML = '<?xml version="1.0" encoding="UTF-8"?> <definitions xmlns="http://www.omg.org/spec/BPMN/20100524/MODEL" xmlns:bpmndi="http://www.omg.org/spec/BPMN/20100524/DI" xmlns:omgdc="http://www.omg.org/spec/DD/20100524/DC" xmlns:omgdi="http://www.omg.org/spec/DD/20100524/DI" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" targetNamespace="" xsi:schemaLocation="http://www.omg.org/spec/BPMN/20100524/MODEL http://www.omg.org/spec/BPMN/2.0/20100501/BPMN20.xsd"> <collaboration id="Collaboration_0j14gki"> <participant id="Participant_0knyncj" name="拖拽设计 流程" processRef="Process_0o49qka" /> <textAnnotation id="TextAnnotation_1h8lnkx">    <text>默认,无须更改</text> </textAnnotation> <textAnnotation id="TextAnnotation_0yej9xz">    <text>默认,无需更改</text> </textAnnotation> <textAnnotation id="TextAnnotation_0wztzgv">    <text>节点操作区域</text> </textAnnotation> <association id="Association_0x31kgf" sourceRef="Participant_0knyncj" targetRef="TextAnnotation_0wztzgv" /> </collaboration> <process id="Process_0o49qka"> <startEvent id="StartEvent_0gsaz4q" name="开始" /> <endEvent id="EndEvent_0jwyxj3" name="结束" /> <association id="Association_0k3w3or" sourceRef="StartEvent_0gsaz4q" targetRef="TextAnnotation_1h8lnkx" /> <association id="Association_054tvu9" sourceRef="EndEvent_0jwyxj3" targetRef="TextAnnotation_0yej9xz" /> </process> <bpmndi:BPMNDiagram id="sid-74620812-92c4-44e5-949c-aa47393d3830"> <bpmndi:BPMNPlane id="sid-cdcae759-2af7-4a6d-bd02-53f3352a731d" bpmnElement="Collaboration_0j14gki"> <bpmndi:BPMNShape id="Participant_0knyncj_di" bpmnElement="Participant_0knyncj"> <omgdc:Bounds x="729" y="-309" width="1089" height="384" /> </bpmndi:BPMNShape> <bpmndi:BPMNShape id="StartEvent_0gsaz4q_di" bpmnElement="StartEvent_0gsaz4q"> <omgdc:Bounds x="826" y="-127" width="36" height="36" /> <bpmndi:BPMNLabel> <omgdc:Bounds x="832" y="-87" width="24" height="13" /> </bpmndi:BPMNLabel> </bpmndi:BPMNShape> <bpmndi:BPMNShape id="EndEvent_0jwyxj3_di" bpmnElement="EndEvent_0jwyxj3"> <omgdc:Bounds x="1698" y="-127" width="36" height="36" /> <bpmndi:BPMNLabel> <omgdc:Bounds x="1704" y="-87" width="24" height="12" /> </bpmndi:BPMNLabel> </bpmndi:BPMNShape> <bpmndi:BPMNShape id="TextAnnotation_1h8lnkx_di" bpmnElement="TextAnnotation_1h8lnkx"> <omgdc:Bounds x="792" y="153" width="104" height="30" /> </bpmndi:BPMNShape> <bpmndi:BPMNEdge id="Association_0k3w3or_di" bpmnElement="Association_0k3w3or"> <omgdi:waypoint xsi:type="omgdc:Point" x="844" y="-91" /> <omgdi:waypoint xsi:type="omgdc:Point" x="844" y="153" /> </bpmndi:BPMNEdge> <bpmndi:BPMNShape id="TextAnnotation_0yej9xz_di" bpmnElement="TextAnnotation_0yej9xz"> <omgdc:Bounds x="1665" y="152" width="102" height="32" /> </bpmndi:BPMNShape> <bpmndi:BPMNEdge id="Association_054tvu9_di" bpmnElement="Association_054tvu9"> <omgdi:waypoint xsi:type="omgdc:Point" x="1716" y="-91" /> <omgdi:waypoint xsi:type="omgdc:Point" x="1716" y="152" /> </bpmndi:BPMNEdge> <bpmndi:BPMNShape id="TextAnnotation_0wztzgv_di" bpmnElement="TextAnnotation_0wztzgv"> <omgdc:Bounds x="1968" y="-132" width="102" height="32" /> </bpmndi:BPMNShape> <bpmndi:BPMNEdge id="Association_0x31kgf_di" bpmnElement="Association_0x31kgf"> <omgdi:waypoint xsi:type="omgdc:Point" x="1818" y="-116" /> <omgdi:waypoint xsi:type="omgdc:Point" x="1968" y="-116" /> </bpmndi:BPMNEdge> </bpmndi:BPMNPlane> <bpmndi:BPMNLabelStyle id="sid-e0502d32-f8d1-41cf-9c4a-cbb49fecf581"> <omgdc:Font name="Arial" size="11" isBold="false" isItalic="false" isUnderline="false" isStrikeThrough="false" /> </bpmndi:BPMNLabelStyle> <bpmndi:BPMNLabelStyle id="sid-84cb49fd-2f7c-44fb-8950-83c3fa153d3b"> <omgdc:Font name="Arial" size="12" isBold="false" isItalic="false" isUnderline="false" isStrikeThrough="false" /> </bpmndi:BPMNLabelStyle> </bpmndi:BPMNDiagram> </definitions>';
  if(xml){
    importXML(xml);
  }else{
    importXML(diagramXML);
  }
})(window.BpmnJS);