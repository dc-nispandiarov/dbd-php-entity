<?php
/********************************************************************************
 *   Apache License, Version 2.0                                                *
 *                                                                              *
 *   Copyright [2020] [Nurlan Mukhanov <nurike@gmail.com>]                      *
 *                                                                              *
 *   Licensed under the Apache License, Version 2.0 (the "License");            *
 *   you may not use this file except in compliance with the License.           *
 *   You may obtain a copy of the License at                                    *
 *                                                                              *
 *       http://www.apache.org/licenses/LICENSE-2.0                             *
 *                                                                              *
 *   Unless required by applicable law or agreed to in writing, software        *
 *   distributed under the License is distributed on an "AS IS" BASIS,          *
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.   *
 *   See the License for the specific language governing permissions and        *
 *   limitations under the License.                                             *
 *                                                                              *
 ********************************************************************************/

namespace DBD\Entity\Tests\Entities\SelfReference;

use DBD\Entity\Column;
use DBD\Entity\Embedded;
use DBD\Entity\Entity;
use DBD\Entity\Interfaces\StrictlyFilledEntity;
use DBD\Entity\Interfaces\SyntheticEntity;
use DBD\Entity\Mapper;

class OneEmbedded extends Entity implements SyntheticEntity, StrictlyFilledEntity
{
    public $id;
    /**
     * @var TwoEmbedded
     */
    public $TwoEmbedded;
}

class OneEmbeddedMap extends Mapper
{
    /**
     * @var Column
     */
    public $id = [
        Column::NAME => 'one_id',
    ];

    /**
     * @var Embedded
     */
    protected $TwoEmbedded = [
        Embedded::NAME => "two",
        Embedded::ENTITY_CLASS => TwoEmbedded::class,
        Embedded::IS_ITERABLE => false,
    ];
}
