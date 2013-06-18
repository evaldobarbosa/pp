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
use Puller\Target\RicardoEletroProductInfo;
use Puller\Target\MagazineLuizaProductInfo;
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
		
		/** RICARDO ELETRO **/
		$request = $this->createRequest("ricardoeletro");
		$hash = md5($request->productURL);
		$filename = "/tmp/RicardoEletroProductInfo-{$hash}.html";
		
		unlink( $filename );
		
		$this->assertFalse( file_exists($filename) );
		
		unset( $request );
		$request = $this->createRequest("ricardoeletro");
		$this->assertTrue( file_exists($filename) );
		
		/** Magazine Luiza **/
		$request = $this->createRequest("magazineluiza");
		$hash = md5($request->productURL);
		$filename = "/tmp/MagazineLuizaProductInfo-{$hash}.html";
		
		unlink( $filename );
		
		$this->assertFalse( file_exists($filename) );
		
		unset( $request );
		$request = $this->createRequest("magazineluiza");
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
		
		$request = $this->createRequest("ricardoeletro");
		$this->assertEquals('326629', $request->productId);
		
		$request = $this->createRequest("magazineluiza");
		$this->assertEquals('0867153', $request->productId);
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
		
		$request = $this->createRequest("ricardoeletro");
		$productName = 'Celular Desbloqueado LG Optimus L5 II Dual E455 Preto - Dual Chip, Android 4.1, Câmera 5 MP, Wi-Fi, MP3, GPS, Bluetooth e Rádio FM';
		$this->assertEquals( $productName, $request->productName );
		
		$request = $this->createRequest("magazineluiza");
		$productName = 'Smartphone 3G Dual Chip LG Optimus L5 II - Android 4.1 Câmera 5MP Tela 4" Wi-Fi';
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
		
		$request = $this->createRequest("ricardoeletro");
		$this->assertEquals('749,00',$request->productPrice);
		
		$request = $this->createRequest("magazineluiza");
		$this->assertEquals('779,00',$request->productPrice);
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
	function testIfTableDescriptionIsCorrect() {
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
		
		/** RICARDO ELETRO **/
		$request = $this->createRequest("ricardoeletro");
		
		$info = $request->productTable;
		
		$this->assertTrue( $info->offsetExists('Cor do Produto') );
		$this->assertTrue( $info->offsetExists('Modelo') );
		$this->assertTrue( $info->offsetExists('Flash Integrado') );
		
		$this->assertEquals( 'Sim', $info->offsetGet('EDGE') );
		
		/** MAGAZINE LUIZA **/
		$request = $this->createRequest("magazineluiza");
		
		$info = $request->productTable;
		
		$this->assertTrue( $info->offsetExists('Marca') );
		$this->assertTrue( $info->offsetExists('Cor') );
		$this->assertTrue( $info->offsetExists('3G') );
		
		$this->assertEquals( 'DualBand', $info->offsetGet('3G') );
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
		$arImg = array(
			'http://images.livrariasaraiva.com.br/imagemnet/imagem.aspx?pro_id=4710182&L=500&A=-1&PIM_Id='=>1,
			'http://images.livrariasaraiva.com.br/imagem/imagem.dll?pro_id=4710182&L=500&A=-1&PIM_Id='=>1
		);
		$this->arrayHasKey($request->productPicture);
		
		unset($request);
		
		$request = $this->createRequest("netshoes");
		$this->assertEquals(
			'http://nsh2.br.netshoes.net/Produtos/06/094-0460-006/094-0460-006_janela.jpg',
			$request->productPicture
		);
		
		unset($request);
		
		$request = $this->createRequest("pontofrio");
		$this->assertEquals(
			'http://www.pontofrio-imagens.com.br/Control/ArquivoExibir.aspx?IdArquivo=6549950',
			$request->productPicture
		);
		
		$request = $this->createRequest("ricardoeletro");
		$this->assertEquals(
			'http://images.maquinadevendas.com.br/370x370/produto/326629_2004826_20130416164443.jpg',
			$request->productPicture
		);
		
		$request = $this->createRequest("magazineluiza");
		$this->assertEquals(
			'http://i.mlcdn.com.br/410x308/smartphone-3g-dual-chip-lg-optimus-l5-iiandroid-4.1-camera-5mp-tela-4-wi-fi-086715300.jpg',
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
			case "ricardoeletro":
				return new RicardoEletroProductInfo( 'Celular-Desbloqueado-LG-Optimus-L5-II-Dual-E455-Preto-Dual-Chip-Android-41-Camera-5-MP-Wi-Fi-MP3-GPS-Bluetooth-e-Radio-FM/44-491-497-296172' );
			case "magazineluiza":
				return new MagazineLuizaProductInfo( 'smartphone-3g-dual-chip-lg-optimus-l5-ii-android-4.1-camera-5mp-tela-4-wi-fi/p/0867153/te/tece/' );
		}
	}
}
