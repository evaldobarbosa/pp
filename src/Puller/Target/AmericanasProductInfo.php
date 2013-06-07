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

class AmericanasProductInfo extends AbstractProductInfo {
  protected function urlMask() {
		return 'http://www.americanas.com.br/produto/%d';
	}
	
	protected function getId() {
		$ret = $this->allInformation;
		
		$regex = '#<span class="id">(.*?)</span>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags($matches[1][0]);
	}
	
	protected function getName() {
		$ret = $this->allInformation;
		
		$regex = '#<h1 class="title">(.*?)</h1>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( trim($matches[1][0]));
	}
	
	protected function getPrice() {
		$ret = $this->allInformation;

		$regex = '#<span class="price">(.*?)</span>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( trim($matches[1][0]));
	}
	
	protected function getDesc() {
		$ret = $this->allInformation;
		
		$regex = '#<div class="chosenProds infoP">(.*?)</div>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( trim($matches[1][0]));
	}
	
	/**
	 * @return \ArrayIterator
	 * @see \Product\AbstractProductInfo::getDescTable()
	 */
	protected function getDescTable() {
		$info = new \ArrayIterator();
		
		$ret = $this->allInformation;
		
		$regex = '#<dt>(.*?)</dt>#is';
		$indexes = array();
		preg_match_all($regex, $ret, $indexes, PREG_PATTERN_ORDER);
		
		$regex = '#<dd class="">(.*?)</dd>#is';
		$values = array();
		preg_match_all($regex, $ret, $values, PREG_PATTERN_ORDER);
		
		foreach ( $indexes[1] as $key=>$val ) {
			if ( !isset($values[1][ $key]) ) {
				break;
			}
			
			$info->offsetSet(
				$val,
				$values[1][
					$key
				]
			);
		}
		
		unset($indexes,$values);
		
		return $info;
	}
	
	protected function getPicture() {
		$ret = strip_tags($this->allInformation,"<img>");
		
		$info = null;
		$regex = '#<img width="250" height="250" id="imgProduto"(.*?[^/])src="(.*?[^/])"(.*?[^/])class="photo" />#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		$info = $matches[2][0]; 
		
		unset($matches);
		
		return $info;
	} 
}
