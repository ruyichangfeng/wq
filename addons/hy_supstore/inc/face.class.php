<?php

/**

 * 	腾讯云人脸识别逻辑流程

 *	https://cloud.tencent.com/document/product/275/6014

 * 

 * 

 */

require_once IA_ROOT. '/addons/hy_supstore/inc/txyunface/index.php';

use QcloudImage\CIClient;

class Face{

	//全局设置

	 public function facebase(){

		global $_W, $_GPC;

		$uniacid = $_W['uniacid'];

		$base = pdo_fetch("select * from ".tablename("hy_supstore_boss")."  where uniacid={$uniacid} ");

		$APP_ID=$base['APP_ID'];	

		$SECRET_ID=$base['SECRET_ID'];

		$SECRET_KEY=$base['SECRET_KEY'];

		$BUCKET=$base['BUCKET'];

		$client = new CIClient($APP_ID, $SECRET_ID, $SECRET_KEY, $BUCKET);

		$client->setTimeout(30);

		return $client;

	}

	

	

	//人脸检测和人脸分析

	public function facedetect($fileurl){

	

	}

	

	//在一个已有的 FaceSet 中找出与目标人脸最相似的一张或多张人脸，返回置信度和不同误识率下的阈值。

	public function facesearch($fileurl){

		$client=$this->facebase();

		$facegroup=$this->facegetgroup();

		

		$result=$client->faceIdentify($facegroup, array('url'=>$fileurl));

		return $result;

	}

	

	//创建一个人脸的集合facecreate

	public function facecreate($fileurl,$openid){

		

		$client=$this->facebase();

		$facegroup=$this->facegetgroup();

		

		//个体创建,创建一个Person，并将Person放置到group_ids指定的组当中，不存在的group_id会自动创建。

		//创建一个Person, 使用图片url-----只需要一个人存一张脸，直接用创建person的方法就行

		$result=$client->faceNewPerson($openid, array($facegroup,), array('url'=>$fileurl), 'xiaoxin');

		

		//增加人脸,将一组Face加入到一个Person中。

		//将单个或者多个Face的url加入到一个Person中

		//$result=$client->faceAddFace('person1', array('urls'=>array($fileurl)));

		return $result;

	}

	

	//全局设置

	public function facegetgroup(){

		global $_W, $_GPC;

		$uniacid = $_W['uniacid'];

		//$group = pdo_fetchcolumn("select facegroup from ".tablename("hy_supstore_boss")."  where uniacid={$uniacid} ");

		$group='group';

		return $group;

	}

}