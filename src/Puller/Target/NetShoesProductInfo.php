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

class NetShoesProductInfo extends AbstractProductInfo {
	protected function urlMask() {
		return 'http://www.netshoes.com.br/produto/%s';
	}
	
	protected function getId() {
		return $this->pid;
	}
	
	protected function getName() {
		$ret = utf8_encode( $this->allInformation );
		
		$regex = '#<h1 class="titProduct" itemprop="name">(.*?)</h1>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( trim($matches[1][0]));
	}
	
	protected function getPrice() {
		$ret = $this->allInformation;
		
		$regex = '#<p class="txtPromo">(.*?)</p>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);

		$ret = $matches[1][0];
		$regex = '#<span itemprop="price">(.*?)</span>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);

		$matches[1][0] = str_replace("$","",$matches[1][0]);
		$matches[1][0] = str_replace(".",",",$matches[1][0]);
		$ret = trim( $matches[1][0] );
		
		return strip_tags( $ret );
	}
	
	protected function getDesc() {
		$ret = utf8_encode( $this->allInformation );
		
		$regex = '#<p class="txtFeatures">(.*?)</p>#is';
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
		
		$ret = $this->allInformation;
		
		$regex = '#<p class="txtFeatures">(.*?)</p>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		$ret = $matches[1][0] . "<br>";
		
		$matches = explode("<br>",$ret);
		$matches[0] = "Descrição: {$matches[0]}";
		
		foreach ( $matches as $key=>$val ) {
			if ( strlen( trim($val) ) == 0 ) {
				continue;
			}
			if ( substr($val,-1) == ":" ) {
				continue;
			}
			
			$ex = explode( ":", strip_tags( $val ) );
			
			if ( count($ex) == 1 ) {
				$info->offsetSet(
					$val,
					$val
				);
			} else {
				$info->offsetSet(
					trim($ex[0]),
					trim($ex[1])
				);
			}
		}
		
		unset($matches);
		
		return $info;
	}
	
	protected function getPicture() {
		$ret = strip_tags($this->allInformation,"<img>");
		$ret = str_replace("'",'"',$ret);
		
		$info = null;
		$regex = '#<img class="imgProduct" src="(.*?)"/>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		$info = $matches[1][0]; 
		
		unset($matches);
		
		return $info;
	} 
}
