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

namespace Puller\Target;

use Puller\AbstractProductInfo;

class RicardoEletroProductInfo extends AbstractProductInfo {
  protected function urlMask() {
  		return 'http://www.ricardoeletro.com.br/Produto/%s';
	}
	
	protected function getId() {
		$ret = $this->allInformation;
		
		$regex = '#<span id="ProdutoDetalhesCodigoProduto">(.*?)</span>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		$id = strip_tags($matches[1][0]);
		$matches = explode( ":", $id );
		$id = $matches[1];
		
		unset( $matches );
		
		return $id;
	}
	
	protected function getName() {
		$ret = utf8_encode( $this->allInformation );
		
		$regex = '#<div id="ProdutoDetalhesNomeProduto" itemprop="name"><h1>(.*?)</h1>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( trim($matches[1][0]));
	}
	
	protected function getPrice() {
		$ret = utf8_encode( $this->allInformation );

		$regex = '#<span id="ProdutoDetalhesPrecoComprarAgoraPrecoDePreco" itemprop="lowPrice">(.*?)</span>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		$ret = trim($matches[1][0]);
		$ret = str_replace("Por&nbsp;R$&nbsp;", "", $ret);
		
		return strip_tags( $ret );
	}
	
	protected function getDesc() {
		$ret = utf8_encode( $this->allInformation );
		
		$regex = '#<div id="ProdutoDetalhes" itemscope itemtype="http://schema.org/Product">(.*?)</div>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( trim($matches[1][0]) );
	}
	
	/**
	 * @return \ArrayIterator
	 * @see \Product\AbstractProductInfo::getDescTable()
	 */
	protected function getDescTable() {
		$info = new \ArrayIterator();
		
		$ret = utf8_encode( $this->allInformation );
		
		$regex = '#<div class="produto-descricao-caracteristicas">(.*?)</div>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		$ret = $matches[1][0];
		
		$regex = '#<tr class="[a-zA-Z0-9]{0,5}"><td>(.*?)</td><td>(.*?)</td></tr>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		foreach ( $matches[1] as $key=>$val ) {
			if ( !isset($matches[2][$key]) ) {
				break;
			}
			
			$info->offsetSet(
				html_entity_decode( trim( $val ) ),
				html_entity_decode( trim( $matches[2][ $key ] ) )
			);
		}
		
		unset($matches);
		
		return $info;
	}
	
	protected function getPicture() {
		$ret = $this->allInformation;
		
		$info = null;
		$regex = '#<div class="foto">(.*?)</div>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		$info = strip_tags( $matches[1][0], "<img>" );
		 
		$regex = '#src="(.*?)"#is';
		$matches = array();
		preg_match_all($regex, $info, $matches, PREG_PATTERN_ORDER);
		
		$info = $matches[1][0];
		
		unset($matches);
		
		return $info;
	} 
}
