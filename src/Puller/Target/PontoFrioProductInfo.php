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

class PontoFrioProductInfo extends AbstractProductInfo {
  protected function urlMask() {
		return 'http://www.pontofrio.com.br/%s';
	}
	
	protected function getId() {
		$ret = $this->allInformation;
		
		$regex = '#<h1 class="fn name">(.*?)</h1>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		$ret = strip_tags( $matches[0][0] ,"<span>");
		
		$regex = '#<span>[ ]\(C&\#243;d. Item (.*?)\)</span>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return trim($matches[1][0]);
	}
	
	protected function getName() {
		$ret = $this->allInformation;
		
		$regex = '#<h1 class="fn name"><b>(.*?)</b>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( html_entity_decode( trim( $matches[1][0] ) ) );
	}
	
	protected function getPrice() {
		$ret = $this->allInformation;
		
		$regex = '#<i class="sale price">(.*?)</i>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);

		$ret = trim( $matches[1][0] );
		
		return strip_tags( $ret );
	}
	
	protected function getDesc() {
		$ret = str_replace("\n","",$this->allInformation);
		
		$regex = '#<div class="CBconteudoTexto"><h4>(.*?)</h4><p>(.*?)</p></div>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		return strip_tags( trim($matches[2][1]) );
	}
	
	/**
	 * @return \ArrayIterator
	 * @see \Product\AbstractProductInfo::getDescTable()
	 */
	protected function getDescTable() {
		$info = new \ArrayIterator();
		
		$ret = $this->allInformation;
		
		$regex = '#<dt>(.*?)</dt>#is';
		$keys = array();
		preg_match_all($regex, $ret, $keys, PREG_PATTERN_ORDER);
		
		$regex = '#<dd>(.*?)</dd>#is';
		$values = array();
		preg_match_all($regex, $ret, $values, PREG_PATTERN_ORDER);
		
		foreach ( $keys[1] as $key=>$val ) {
			if ( !isset($values[1][$key]) ) {
				continue;
			}

			$newVal = trim(strip_tags($values[1][$key]));
			$newVal = str_replace("\n", "", $newVal);
			$newVal = str_replace("\t", "", $newVal);
			$newVal = str_replace(",&nbsp;", "", $newVal);
			$newVal = str_replace("&nbsp;", "", $newVal);
			$info->offsetSet(
				trim($val),
				$newVal
			);
		}
		
		unset($keys,$values);
		
		return $info;
	}
	
	protected function getPicture() {
		$ret = $this->allInformation;
		$ret = str_replace("\n","",$ret);
		
		$regex = '#<div id="divFullImage">(.*?)</div>#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);
		
		$ret = strip_tags($matches[1][0],"<img>");
		
		$info = null;
		$regex = '#<img src="(.*?)"#is';
		$matches = array();
		preg_match_all($regex, $ret, $matches, PREG_PATTERN_ORDER);

		$ret = trim($matches[1][0]);
		
		unset($matches);
		
		return $ret;
	} 
}
