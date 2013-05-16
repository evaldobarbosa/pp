<?php
/*******************************************************************************
* Copyright 2012 Evaldo Barbosa
*
* This file is part of Product Puller.
*
* Product Puller is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* Product Puller is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Product Puller; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*
*******************************************************************************/

use Puller\Target\SubmarinoProductInfo;
use Puller\Target\AmericanasProductInfo;
/**
 * @group Info
 * @author evaldo
 *
 */
class ProductInfoTest extends PHPUnit_Framework_TestCase {
  function testIfRequestCanCreateCacheFile() {
		$request = $this->createRequest("submarino");
		$hash = md5($request->productURL);
		$filename = "/tmp/SubmarinoProductInfo-{$hash}.html";
		
		unlink( $filename );
		
		$this->assertFalse( file_exists($filename) );
		
		unset( $request );
		$request = $this->createRequest("submarino");
		$this->assertTrue( file_exists($filename) );
		
		/** AMERICANAS **/
		$request = $this->createRequest("americanas");
		$hash = md5($request->productURL);
		$filename = "/tmp/AmericanasProductInfo-{$hash}.html";
		
		unlink( $filename );
		
		$this->assertFalse( file_exists($filename) );
		
		unset( $request );
		$request = $this->createRequest("americanas");
		$this->assertTrue( file_exists($filename) );
	}
	
	/**
	 * @depends testIfRequestCanCreateCacheFile
	 */
	function testProductNameIsCorrect() {
		$request = $this->createRequest("submarino");

		$this->assertEquals('111970051', $request->productId);
		
		$request = $this->createRequest("americanas");
		
		$this->assertEquals('111970051', $request->productId);
	}
	
	/**
	 * @depends testIfRequestCanCreateCacheFile
	 */
	function testIf2ProductNameIsCorrect() {
		$request = $this->createRequest("submarino");
		
		$productName = 'Smartphone Motorola RAZR i, GSM, Preto, Processador Intel Inside® 2GHz, Tela AMOLED Advanced 4.3", Touchscreen, Android 4.0, Câmera de 8MP , Câmera Frontal VGA, Gravação Full HD, 3G, Wi-Fi, Bluetooth, GPS, NFC, Memória interna de 8GB';
		
		$this->assertEquals( $productName, $request->productName );
		
		$request = $this->createRequest("americanas");
		
		$productName = 'Smartphone Motorola RAZR i, GSM, Preto, Processador Intel Inside® 2GHz, Tela AMOLED Advanced 4.3", Touchscreen, Android 4.0, Câmera de 8MP , Câmera Frontal VGA, Gravação Full HD, 3G, Wi-Fi, Bluetooth, GPS, NFC, Memória interna de 8GB';
		
		$this->assertEquals( $productName, $request->productName );
	}
	
	/**
	 * @depends testIfRequestCanCreateCacheFile
	 */
	function testIf2ProductPriceIsCorrect() {
		$request = $this->createRequest("submarino");
		
		$this->assertEquals('999,00',$request->productPrice);
		
		$request = $this->createRequest("americanas");
		
		$this->assertEquals('999,00',$request->productPrice);
	}
	
	/**
	 * @depends testIfRequestCanCreateCacheFile
	 */
	function testIf200FirstCharsAreCorrect() {
		$request = $this->createRequest("submarino");
		
		$first200Chr = 'Smartphone Motorola RAZR i, GSM, Preto, Processador Intel Inside® 2GHz, Tela AMOLED Advanced 4.3", Touchscreen, Android 4.0, Câmera de 8MP , Câmera Frontal VGA, Gravação Full HD, 3G, Wi-Fi, Bluetooth';
		
		$this->assertEquals( $first200Chr, substr($request->productInfo, 0, strlen($first200Chr)) );
	}
	
	/**
	 * @depends testIfRequestCanCreateCacheFile
	 */
	function testIfTableDescriptionAreCorrect() {
		$request = $this->createRequest("submarino");
		
		$info = $request->productTable;
		
		$this->assertTrue( $info->offsetExists('WAP') );
		$this->assertTrue( $info->offsetExists('Toques') );
		$this->assertTrue( $info->offsetExists('Dual Core') );
		
		$this->assertEquals( '4.3"', $info->offsetGet('Tamanho do Display') );
		
		$request = $this->createRequest("americanas");
		
		$info = $request->productTable;
		
		$this->assertTrue( $info->offsetExists('WAP') );
		$this->assertTrue( $info->offsetExists('Toques') );
		$this->assertTrue( $info->offsetExists('Dual Core') );
		
		$this->assertEquals( '4.3"', $info->offsetGet('Tamanho do Display') );
	}
	
	/**
	 * @depends testIfRequestCanCreateCacheFile
	 */
	function testIf2ProductPictureIsCorrect() {
		$request = $this->createRequest("submarino");
	
		$this->assertEquals(
			'http://img.submarino.com.br/produtos/01/00/item/111970/0/111970051G1.jpg',
			$request->productPicture
		);
		
		unset($request);
		
		$request = $this->createRequest("americanas");
		
		$this->assertEquals(
				'http://img.americanas.com.br/produtos/01/00/item/111970/0/111970051G1.jpg',
				$request->productPicture
		);
	}
	
	private function createRequest($site) {
		switch ( $site ) {
			case "submarino":
				return new SubmarinoProductInfo( '111970051' );
			case "americanas":
				return new AmericanasProductInfo( '111970051' );
		}
	}
}
