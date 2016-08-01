<?php

class Telekloud extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$dom = new DOMDocument();
		$dom->load('./testxml/product.xml');
		$products = $dom->getElementsByTagName('COREProduct');
		//print_r($products);
		$i =1;
		 foreach($products as $product){
			$pIdById  = $product->getAttribute('id'); 
			
			$names = $product->getElementsByTagName( "NAME" );
			$name  = $names->item(0)->nodeValue;

			$descs = $product->getElementsByTagName( "DESCRIPTION" );
			$desc  = $descs->item(0)->nodeValue;
			
			$setupPrices = $product->getElementsByTagName( "SETUP_PRICE" );
			$setupPrice  = $setupPrices->item(0)->nodeValue;
			
			$prices = $product->getElementsByTagName( "PRICE" );
			$price  = $prices->item(0)->nodeValue;
			
			$groupes = $product->getElementsByTagName( "GROUP" );
			$group  = $groupes->item(0)->nodeValue;
			
			$groupesId = $product->getElementsByTagName( "GROUP" );
			$groupId  = $groupesId->item(0)->getAttribute('id');
			
			$var1s = $product->getElementsByTagName( "VAR1" );
			$var1  = $var1s->item(0)->nodeValue;
			
			$var2s = $product->getElementsByTagName( "VAR2" );
			$var2  = $var2s->item(0)->nodeValue;
			
			$var3s = $product->getElementsByTagName( "VAR3" );
			$var3  = $var3s->item(0)->nodeValue;
			
			$var4s = $product->getElementsByTagName( "VAR4" );
			$var4  = $var4s->item(0)->nodeValue;
			
			$var5s = $product->getElementsByTagName( "VAR5" );
			$var5  = $var5s->item(0)->nodeValue;
			
			$var6s = $product->getElementsByTagName( "VAR6" );
			$var6  = $var6s->item(0)->nodeValue;
			
			$var7s = $product->getElementsByTagName( "VAR7" );
			$var7  = $var7s->item(0)->nodeValue;
			
			$var8s = $product->getElementsByTagName( "VAR8" );
			$var8  = $var8s->item(0)->nodeValue;
			
			$var9s = $product->getElementsByTagName( "VAR9" );
			$var9  = $var9s->item(0)->nodeValue;
			
			$var10s = $product->getElementsByTagName( "VAR10" );
			$var10  = $var10s->item(0)->nodeValue;
			
			$var11s = $product->getElementsByTagName( "VAR11" );
			$var11  = $var11s->item(0)->nodeValue;
			
			$var12s = $product->getElementsByTagName( "VAR12" );
			$var12  = $var12s->item(0)->nodeValue;
			
			$var13s = $product->getElementsByTagName( "VAR13" );
			$var13  = $var13s->item(0)->nodeValue;
			
			$var14s = $product->getElementsByTagName( "VAR14" );
			$var14  = $var14s->item(0)->nodeValue;
			
			$var15s = $product->getElementsByTagName( "VAR15" );
			$var15  = $var15s->item(0)->nodeValue; 							
			$tmp = array(
				'pro_id'=>$pIdById,
				'name'  =>  $name,
				'desc'  =>  $desc,
				'setupPrice'  =>  $setupPrice,
				'price'  =>  $price,
				'group_id'  =>  $groupId,
				'group_desc'  =>  $group,
				'var1'  =>  $var1,
				'var2'  =>  $var2,
				'var3'  =>  $var3,
				'var4'  =>  $var4,
				'var5'  =>  $var5,
				'var6'  =>  $var6,
				'var7'  =>  $var7,
				'var8'  =>  $var8,
				'var9'  =>  $var9,
				'var10'  =>  $var10,
				'var11'  =>  $var11,
				'var12'  =>  $var12,
				'var13'  =>  $var13,
				'var14'  =>  $var14,
				'var15'  =>  $var15,
			);
			$onlegacyMobilePlan = array(
										'p_id'=>$pIdById,
										'g_id'  =>  $groupId,
									);
			if(!$this->db->insert('onlegacy_mobile_plan_info',$onlegacyMobilePlan)){
				echo $this->db->_error_message();
			}else{
				echo '<br/><br/><br/><br/><br/>';
				print_r($tmp);
				echo $i .'<br/><br/><br/><br/><br/>';
			} 		
		}
		
		$varproducts = $dom->getElementsByTagName('VARProduct');
		foreach($varproducts as $varproduct){
			$varProductIDs = $varproduct->getAttribute('id'); 
			
			$productID = $varproduct->getElementsByTagName( "PRODUCTID" );
			$pID  = $productID->item(0)->nodeValue;
			
			$vvarids = $varproduct->getElementsByTagName( "VARID" );
			$vvarid  = $vvarids->item(0)->nodeValue;
			
			$vnames = $varproduct->getElementsByTagName( "NAME" );
			$vname  = $vnames->item(0)->nodeValue;

			$vdescs = $varproduct->getElementsByTagName( "DESCRIPTION" );
			$vdesc  = $vdescs->item(0)->nodeValue;
			
			$vprices = $varproduct->getElementsByTagName( "PRICE" );
			$vprice  = $vprices->item(0)->nodeValue; 

			$vsetupprices = $varproduct->getElementsByTagName( "SETUP_PRICE" );
			$vsetupprice  = $vsetupprices->item(0)->nodeValue;
			
			$vstauss = $varproduct->getElementsByTagName( "STATUS" );
			$vstaus  = $vstauss->item(0)->nodeValue;
			
			$tmp1 = array(
				'pro_id'=>$pIdById,
				'group_id'  =>  $groupId,
				'varProID'  =>  $varProductIDs,
				'varID'  =>  $vvarid,
				'vname'  =>  $vname,
				'vdesc'  =>  $vdesc,
				'vprice'  =>  $vprice,
				'varSetupPrice'  =>  $vsetupprice,
				'varProStatus'  =>  $vstaus
			);
			
			$onlegacyMobilePlan = array(
										'var_pro_id'=>$varProductIDs,
										'var_id'  =>  $vvarid,
										'var_pro_name'  =>  $vname,
										'var_pro_desc'  =>  $vdesc,
										'var_pro_price'  =>  $vprice,
										'var_pro_setup_price'  =>  $vsetupprice,
										'var_pro_status'  =>  $vstaus,
									);
			if(!$this->db->update('onlegacy_mobile_plan_info',$onlegacyMobilePlan,array('p_id'=>$pID))){
				echo $this->db->_error_message();
			}else{
				print_r($onlegacyMobilePlan);
				echo $i .'<br/><br/><br/><br/><br/>';
			}
		}
		
		
	}
	
	function index1(){
		//$data = $this->onlegacy_mdl->searchTeleKloudProductAvailavle();
		$data = $this->onlegacy_mdl->searchTeleKloudProduct();
		$this->load->helper('file');
		write_file('./testxml/product.xml', $data);
		/* //$product ="<?xml version='1.0'?>"; */
		$product = simplexml_load_file('./testxml/product.xml');
		echo  $data; 
		//echo $product->COREProduct[0]->name;
		/* foreach($product->TELEKLOUD as $value){
			print_r($value);
		} */
	}
	
	function newCustomer(){
		    $request = "<TELEKLOUD>
							<auth>
								<VARID>2777866318</VARID>
								<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
								<USER>info@onlegacynetwork.com</USER>
								<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
							</auth>
							<service>CUSTOMER_CUSTOMER</service>
							<CUSTOMER_ACCOUNT_NUMBER>2312312</CUSTOMER_ACCOUNT_NUMBER>
							<DATA1>onlegacynetwork1</DATA1>
							<DATA2>onlegacy1</DATA2>
							<DATA3>test1</DATA3>
							<DATA4>214 Westmoreland Dr</DATA4>
							<DATA5>APT</DATA5>
							<DATA6>34545</DATA6>
							<DATA7>540056</DATA7>
							<DATA8>onlegacyme@me.com</DATA8>
							<DATA9>9035551212</DATA9>
							<DATA10>06251979</DATA10>
							<DATA11></DATA11>
							<DATA12></DATA12>
							<DATA13></DATA13>
							<DATA14></DATA14>
							<DATA15>1</DATA15>
							<DATA16>Bangalore</DATA16>
							<DATA17>Karnatak</DATA17>
							<DATA18>India</DATA18>
						</TELEKLOUD>";
			 
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);;
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
			$response = curl_exec($curl);
			curl_close ($curl);
			 
			 
			//show the response
			header ("content-type: text/xml");
			echo $response; 
	}
	
		function customerOrder(){
		    $request = "<TELEKLOUD>
							<auth>
								<VARID>2777866318</VARID>
								<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
								<USER>info@onlegacynetwork.com</USER>
								<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
							</auth>
							<service>CUSTOMER_ORDER</service>
							<CUSTOMER_ACCOUNT_NUMBER>7104233</CUSTOMER_ACCOUNT_NUMBER>
							<DATA1>26</DATA1>
							<DATA2></DATA2>
							<DATA3></DATA3>
							<DATA4></DATA4>
							<DATA5></DATA5>
							<DATA6></DATA6>
							<DATA7></DATA7>
							<DATA8></DATA8>
							<DATA9></DATA9>
							<DATA10></DATA10>
							<DATA11></DATA11>
							<DATA12></DATA12>
							<DATA13></DATA13>
							<DATA14></DATA14>
							<DATA15></DATA15>
							<DATA16></DATA16>
							<DATA17></DATA17>
							<DATA18></DATA18>
							<DATA19></DATA19>
							<DATA20></DATA20>
							<DATA21></DATA21>
						</TELEKLOUD>";
			 
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);;
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
			$response = curl_exec($curl);
			curl_close ($curl);
			 
			 
			//show the response
			header ("content-type: text/xml");
			echo $response; 
	}
	
	function getPlan($grupID=21){
		header('Content-Type: application/json');
		$data = $this->mdl_common->allSelects('SELECT * FROM telekloud_plan_info WHERE varProID!="" AND vname!="" AND varProStatus="1" AND group_id='.$grupID);
		if(isset($data) && !empty($data)){
			foreach ($data as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}
}