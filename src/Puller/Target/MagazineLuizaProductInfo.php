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

class MagazineLuizaProductInfo extends AbstractProductInfo {
  protected function urlMask() {
  	return 'http://www.magazineluiza.com.br/%s';
	}
	
	protected function getId() {
		$ret = $this->allInformation;
		
		$regex = '#<small itemprop="productID">\((.*?)\)</small>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return preg_replace( "/[^0-9]+/", "", $matches[1][0] );
	}
	
	protected function getName() {
		$ret = $this->allInformation;
		$regex = '#<h1 itemprop="name">(.*?)</h1>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( trim($matches[1][0]));		
	}
	
	protected function getPrice() {
		$ret = $this->allInformation;
		
		$regex = '#<span class="right-price">(.*?)</span>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags(trim($matches[1][1]));
	}
	
	protected function getDesc() {
		$ret = $this->allInformation;
		
		$regex = '#<strong class="fs-presentation">(.*?)</strong>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags(trim($matches[1][0]));
	}
	
	/**
	 * @return \ArrayIterator
	 * @see \Product\AbstractProductInfo::getDescTable()
	 */
	protected function getDescTable() {
		$info = new \ArrayIterator();
		
		$ret = $this->allInformation;
		$ret = preg_replace("([\\n\\r\\t]+)","",$ret);
		$ret = preg_replace("(>[ ]+<)","><",$ret);
		$ret = str_replace("<p></p>","",$ret);
		$_info = array();
		
		$regex  = '#<div class="fs-row"><strong>(.*?)</strong><div class="fs-right">(.*?)</div></div>#is';
		
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		foreach( $matches[1] as $key=>$value ) {
			$m = array();
			$regex  = '#<div><p>(.*?)</p>#is';
			preg_match_all($regex, $matches[2][$key], $m, PREG_PATTERN_ORDER);

			$step = false;
			if ( count($m) == 2 && !empty($m[1][0]) ) {
				$info->offsetSet(
						$value,
						strip_tags( trim($m[1][0]) )
				);
				$step = true;
			}
			if ( $step ) {
				continue;
			}
			
			$m = array();
			$regex  = '#<div>(<span>(.*?)</span><p>(.*?)</p>)#is';
			preg_match_all($regex, $matches[2][$key], $m, PREG_PATTERN_ORDER);
			
			foreach( $m[2] as $k1=>$v1 ) {
				if ( $info->offsetExists($m[2][$k1]) ) {
					$m[2][$k1] = "{$m[2][$k1]} ({$value})";
				}
				
				$info->offsetSet(
					$m[2][$k1],
					strip_tags( trim($m[3][$k1]) )
				);
			}
		}
		return $info;
	}
	
	protected function getPicture() {
		$ret = $this->allInformation;
		
		$info = null;
		$regex = '#<img itemprop="image" src="(.*?)"#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		$info = $matches[1][0]; 
		
		unset($matches);
		
		return $info;
	} 
}
