<?php
/*
* Copyright 2013 Evaldo Barbosa
* 
* This file is part of Product Puller.
* 
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 3 of the License, or (at your option) any later version.
* 
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
* 
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/

use Puller\Target\SubmarinoProductInfo;
use Puller\Target\AmericanasProductInfo;
use Puller\Target\SaraivaProductInfo;
use Puller\Target\NetShoesProductInfo;
use Puller\Target\PontoFrioProductInfo;
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
		
		/** SARAIVA **/
		$request = $this->createRequest("saraiva");
		$hash = md5($request->productURL);
		$filename = "/tmp/SaraivaProductInfo-{$hash}.html";
		
		unlink( $filename );
		
		$this->assertFalse( file_exists($filename) );
		
		unset( $request );
		$request = $this->createRequest("saraiva");
		$this->assertTrue( file_exists($filename) );
		
		/** PONTO FRIO **/
		$request = $this->createRequest("pontofrio");
		$hash = md5($request->productURL);
		$filename = "/tmp/PontoFrioProductInfo-{$hash}.html";
		
		unlink( $filename );
		
		$this->assertFalse( file_exists($filename) );
		
		unset( $request );
		$request = $this->createRequest("pontofrio");
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
		
		$request = $this->createRequest("saraiva");
		$this->assertEquals('4710182', $request->productId);
		
		$request = $this->createRequest("netshoes");
		$this->assertEquals('094-0460-014-03', $request->productId);
		
		$request = $this->createRequest("pontofrio");
		$this->assertEquals('1748861', $request->productId);
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
		
		$request = $this->createRequest("saraiva");
		$productName = 'Game Of Thrones - 1ª e 2ª Temporada Completa - 10 DVDs';
		$this->assertEquals( $productName, $request->productName );
		
		$request = $this->createRequest("netshoes");
		$productName = 'Camiseta Billabong Crossroads';
		$this->assertEquals( $productName, $request->productName );
		
		$request = $this->createRequest("pontofrio");
		$productName = 'Celular Desbloqueado Motorola RAZR™ i Preto com Processador Intel® de 2 GHz, Tela de 4.3’’, Android 4.0, Câmera 8MP, Wi-Fi, 3G, NFC, GPS e Bluetooth';
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
		
		$request = $this->createRequest("saraiva");
		$this->assertEquals('169,90',$request->productPrice);
		
		$request = $this->createRequest("netshoes");
		$this->assertEquals('79,90',$request->productPrice);
		
		$request = $this->createRequest("pontofrio");
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
		
		/** AMERICANAS **/
		$request = $this->createRequest("americanas");
		
		$info = $request->productTable;
		
		$this->assertTrue( $info->offsetExists('WAP') );
		$this->assertTrue( $info->offsetExists('Toques') );
		$this->assertTrue( $info->offsetExists('Dual Core') );
		
		$this->assertEquals( '4.3"', $info->offsetGet('Tamanho do Display') );
		
		/** SARAIVA **/
		$request = $this->createRequest("saraiva");
		
		$info = $request->productTable;
		
		$this->assertTrue( $info->offsetExists('Cód. Barras') );
		$this->assertTrue( $info->offsetExists('Altura') );
		$this->assertTrue( $info->offsetExists('Largura') );
		
		$this->assertEquals( 'SIM', $info->offsetGet('Colorido') );
		
		/** NETSHOES **/
		$request = $this->createRequest("netshoes");
		
		$info = $request->productTable;
			
		$this->assertTrue( $info->offsetExists('Composição') );
		$this->assertTrue( $info->offsetExists('Garantia do fabricante') );
		$this->assertTrue( $info->offsetExists('Origem') );
		
		$this->assertEquals( '50x88 cm (LxA).', $info->offsetGet('GG') );
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
		
		unset($request);
		
		$request = $this->createRequest("saraiva");
		$this->assertEquals(
				'http://images.livrariasaraiva.com.br/imagem/imagem.dll?pro_id=4710182&L=500&A=-1&PIM_Id=',
				$request->productPicture
		);
		
		unset($request);
		
		$request = $this->createRequest("netshoes");
		$this->assertEquals(
				'http://nsh.br.netshoes.net/Produtos/06/094-0460-006/094-0460-006_janela.jpg',
				$request->productPicture
		);
		
		unset($request);
		
		$request = $this->createRequest("pontofrio");
		$this->assertEquals(
				'http://www.pontofrio-imagens.com.br/Control/ArquivoExibir.aspx?IdArquivo=6549950',
				$request->productPicture
		);
	}
	
	private function createRequest($site) {
		switch ( $site ) {
			case "submarino":
				return new SubmarinoProductInfo( '111970051' );
			case "americanas":
				return new AmericanasProductInfo( '111970051' );
			case "saraiva":
				return new SaraivaProductInfo( '4710182' );
			case "netshoes":
				return new NetShoesProductInfo( '094-0460-014-03' );
			case "pontofrio":
				return new PontoFrioProductInfo( 'TelefoneseCelulares/Smartphones/Celular-Desbloqueado-Motorola-RAZR-i-Preto-com-Processador-Intel-de-2-GHz-Tela-de-4-3’’-Android-4-0-Camera-8MP-Wi-Fi-3G-NFC-GPS-e-Bluetooth-1748861.html' );
		}
	}
}
