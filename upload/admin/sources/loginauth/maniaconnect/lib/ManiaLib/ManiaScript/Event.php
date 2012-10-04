<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 735 $:
 * @author      $Author: maximeraoust $:
 * @date        $Date: 2012-07-19 11:48:15 +0200 (jeu., 19 juil. 2012) $:
 */

namespace ManiaLib\ManiaScript;

use ManiaLib\Gui\Manialink;

/**
 * @see http://code.google.com/p/manialib/source/browse/trunk/media/maniascript/manialib.xml
 */
abstract class Event
{
	const mouseClick = 'CMlEvent::Type::MouseClick';
	const mouseOver = 'CMlEvent::Type::MouseOver';
	const mouseOut = 'CMlEvent::Type::MouseOut';

	static function addListener($controlId, $eventType, array $action)
	{
		$script = 'manialib_event_add_listener("%s", %s, %s); ';
		$controlId = Tools::escapeString($controlId);
		$action = Tools::array2maniascript($action);
		$script = sprintf($script, $controlId, $eventType, $action);
		Manialink::appendScript($script);
	}

}

?>