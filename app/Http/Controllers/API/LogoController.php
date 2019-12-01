<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Font;
use App\Container;
use App\Logo;
use App\LogoName;
use App\LogoSlogan;
use App\LogoInitial;
use App\LogoIcon;
use App\LogoContainer;
use App\Order;
use App\Services\StringEncodeDecodeService;

class LogoController extends Controller
{
    public function store(Request $request)
    {
        try {
            $orders = Order::where('logo_id', '=', $request->get('id'))->get();

            $purchased = count($orders) > 0;
            $logoId = $request->get('id');

            $name = $request->get('name');
            $logoNameId = $name['id'];

            $slogan = $request->get('slogan');
            $logoSloganId = $slogan['id'];

            $icon = $request->get('icon');
            $logoIconId = $icon['id'];

            $initials = $request->get('initials');
            $logoInitialsId = $initials['id'];

            $container = $request->get('container');
            $logoContainerId = $container['id'];

            $result = [];

            if ($purchased) {
                $logo = Logo::findOrFail($logoId);
                $logo = $logo->replicate();
                $logo->save();
                $logoId = $logo->id;
                $result['id'] = $logoId;

                $logoName = LogoName::find($logoNameId);
                if (! empty($logoName)) {
                    $logoName = $logoName->replicate();
                    $logoName->save();
                    $logoNameId = $logoName->id;
                    $result['name_id'] = $logoNameId;
                }

                $logoSlogan = LogoSlogan::find($logoSloganId);
                if (! empty($logoSlogan)) {
                    $logoSlogan = $logoSlogan->replicate();
                    $logoSlogan->save();
                    $logoSloganId = $logoSlogan->id;
                    $result['slogan_id'] = $logoSloganId;
                }

                $logoIcon = LogoIcon::find($logoIconId);
                if (! empty($logoIcon)) {
                    $logoIcon = $logoIcon->replicate();
                    $logoIcon->save();
                    $logoIconId = $logoIcon->id;
                    $result['icon_id'] = $logoIconId;
                }

                $logoInitials = LogoInitial::find($logoInitialsId);
                if (! empty($logoInitials)) {
                    $logoInitials = $logoInitials->replicate();
                    $logoInitials->save();
                    $logoInitialsId = $logoInitials->id;
                    $result['initials_id'] = $logoInitialsId;
                }

                $logoContainer = LogoContainer::find($logoContainerId);
                if (! empty($logoContainer)) {
                    $logoContainer = $logoContainer->replicate();
                    $logoContainer->save();
                    $logoContainerId = $logoContainer->id;
                    $result['logo_container_id'] = $logoContainerId;
                }
            }

            $logo = Logo::updateOrCreate([
                'id' => $logoId
            ],[
                'bg_color' => $request->get('bg_color'),
                'layout' => $request->get('layout', ''),
                'scale' => $request->get('scale', 1.0),
                'svg' => $request->get('svg', ''),
                'symbol_only_svg' => $request->get('symbol_only_svg', ''),
                'user_id' => \Auth::id(),
            ]);

            $result['id'] = $logo->id;

            if (isset($name['text']) && !empty($name['text'])) {
                $logoName = LogoName::updateOrCreate([
                    'id' => $logoNameId,
                ], [
                    'font_id' => $name['font_id'],
                    'text' => $name['text'],
                    'font_size' => $name['font_size'],
                    'letter_space' => $name['letter_space'],
                    'line_space' => $name['line_space'],
                    'color_hex' => $name['color_hex'],
                    'color_opacity' => $name['color_opacity'],
                    'capitalization' => $name['capitalization'],
                    'logo_id' => $logo->id,
                ]);
                $result['name_id'] = $logoName->id;
            } else {
                LogoName::where('logo_id', $logo->id)->delete();
                $result['name_id'] = 0;
            }

            if (isset($slogan['text']) && !empty($slogan['text'])) {
                $logoSlogan = LogoSlogan::updateOrCreate([
                    'id' => $logoSloganId,
                ], [
                    'font_id' => $slogan['font_id'],
                    'text' => $slogan['text'],
                    'font_size' => $slogan['font_size'],
                    'letter_space' => $slogan['letter_space'],
                    'line_space' => $slogan['line_space'],
                    'color_hex' => $slogan['color_hex'],
                    'color_opacity' => $slogan['color_opacity'],
                    'capitalization' => $slogan['capitalization'],
                    'logo_id' => $logo->id,
                ]);
                $result['slogan_id'] = $logoSlogan->id;
            } else {
                LogoSlogan::where('logo_id', $logo->id)->delete();
                $result['slogan_id'] = 0;
            }

            if (isset($icon['tags']) && !empty($icon['tags'])) {
                $logoIcon = LogoIcon::updateOrCreate([
                    'id' => $logoIconId
                ], [
                    'tags' => $icon['tags'],
                    'min_x' => $icon['bounds']['minX'],
                    'min_y' => $icon['bounds']['minY'],
                    'max_x' => $icon['bounds']['maxX'],
                    'max_y' => $icon['bounds']['maxY'],
                    'clip_rule' => $icon['clip_rule'],
                    'fill_rule' => $icon['fill_rule'],
                    'size' => $icon['size'],
                    'line_space' => $icon['line_space'],
                    'color_hex' => $icon['color_hex'],
                    'color_opacity' => $icon['color_opacity'],
                    'hidden' => $icon['hidden'],
                    'logo_id' => $logo->id,
                ]);
                $result['icon_id'] = $logoIcon->id;
            } else {
                LogoIcon::where('logo_id', $logo->id)->delete();
                $result['icon_id'] = 0;
            }

            if (isset($initials['text']) && !empty($initials['text'])) {
                $logoInitials = LogoInitial::updateOrCreate([
                    'id' => $logoInitialsId,
                ], [
                    'font_id' => $initials['font_id'],
                    'text' => $initials['text'],
                    'font_size' => $initials['font_size'],
                    'letter_space' => $initials['letter_space'],
                    'line_space' => $initials['line_space'],
                    'color_hex' => $initials['color_hex'],
                    'color_opacity' => $initials['color_opacity'],
                    'logo_id' => $logo->id,
                ]);
                $result['initials_id'] = $logoInitials->id;
            } else {
                LogoInitial::where('logo_id', $logo->id)->delete();
                $result['initials_id'] = 0;
            }

            if (isset($container['container_id']) && !empty($container['container_id'])) {
                $logoContainer = LogoContainer::updateOrCreate([
                    'id' => $logoContainerId,
                ], [
                    'container_id' => $container['container_id'],
                    'size' => $container['size'],
                    'color_hex' => $container['color_hex'],
                    'color_opacity' => $container['color_opacity'],
                    'logo_id' => $logo->id,
                ]);
                $result['logo_container_id'] = $logoContainer->id;
            } else {
                LogoContainer::where('logo_id', $logo->id)->delete();
                $result['logo_container_id'] = 0;
            }

            return $this->response([
                'status' => 'success',
                'payload' => [
                    'result' => $result,
                ],
            ], 200);

        } catch (\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage(),
                ],
            ], 200);
        }
    }

    public function listByUser()
    {
        $logos = \Auth::user()->logos->map(function($logo) {
            $state = [
                'settings' => [
                    'width'     => 1024,
                    'height'    => 768,

                    'id' => $logo->id,
                    'backgroundColor' => [
                        'hex' => $logo->bg_color
                    ],
                    'layout' => $logo->layout,
                    'scale' => $logo->scale,

                    'svg' => $logo->svg,
                ]
            ];

            $name = $logo->name;
            $state['companyNameSettings'] = [
                'id' => optional($name)->id ?? 0,
                'text' => optional($name)->text ?? '',
                'fontSize' => optional($name)->font_size ?? 20,
                'fontBounds' => [
                    'minX' => 0,
                    'minY' => 0,
                    'maxX' => 0,
                    'maxY' => 0,
                ],
                'fontAdvX' => 0,
                'letterSpace' => optional($name)->letter_space ?? 0,
                'lineSpace' => optional($name)->line_space ?? 50,
                'font' => !empty(optional($name)->font_id) ? Font::findOrFail($name->font_id) : [],
                'color' => [
                    'hex' => optional($name)->color_hex ?? '#D9D525',
                    'rgba' => [
                        'r' => hexdec(substr(optional($name)->color_hex ?? '#D9D525', 1, 2)),
                        'g' => hexdec(substr(optional($name)->color_hex ?? '#D9D525', 3, 2)),
                        'b' => hexdec(substr(optional($name)->color_hex ?? '#D9D525', 5, 2)),
                        'a' => optional($name)->color_opacity ?? 1
                    ],
                    'a' => optional($name)->color_opacity ?? 1
                ],
                'capitalization' => optional($name)->capitalization ?? '',
                'paths' => [],
                'width' => 0,
                'height' => 0,
                'scale' => 1,
            ];

            $slogan = $logo->slogan;
            $state['sloganSettings'] = [
                'id' => optional($slogan)->id ?? 0,
                'text' => optional($slogan)->text ?? '',
                'fontSize' => optional($slogan)->font_size ?? 10,
                'fontBounds' => [
                    'minX' => 0,
                    'minY' => 0,
                    'maxX' => 0,
                    'maxY' => 0,
                ],
                'fontAdvX' => 0,
                'letterSpace' => optional($slogan)->letter_space ?? 0,
                'lineSpace' => optional($slogan)->line_space ?? 0,
                'font' => !empty(optional($slogan)->font_id) ? Font::findOrFail($slogan->font_id) : [],
                'color' => [
                    'hex' => optional($slogan)->color_hex ?? '#D9D525',
                    'rgba' => [
                        'r' => hexdec(substr(optional($slogan)->color_hex ?? '#D9D525', 1, 2)),
                        'g' => hexdec(substr(optional($slogan)->color_hex ?? '#D9D525', 3, 2)),
                        'b' => hexdec(substr(optional($slogan)->color_hex ?? '#D9D525', 5, 2)),
                        'a' => optional($slogan)->color_opacity ?? 1
                    ],
                    'a' => optional($slogan)->color_opacity ?? 1
                ],
                'capitalization' => optional($slogan)->capitalization ?? '',
                'paths' => [],
                'width' => 0,
                'height' => 0,
                'scale' => 1,
            ];

            $icon = $logo->icon;
            $initials = $logo->initials;
            $state['symbolSettings'] = [
                'types' => [
                    [
                        'label'=> 'Icon',// also used as key of type
                        'icon'=> 'logobot-icon icon-gem',
                        'selected'=> strpos($logo->layout, 'initial') === false
                    ],
                    [
                        'label'=> 'Initials',
                        'icon'=> 'logobot-icon icon-heading',
                        'selected'=> strpos($logo->layout, 'initial') !== false
                    ],
                ],

                'iconId' => optional($icon)->id ?? 0,
                'tags' => optional($icon)->tags ?? [],
                'iconBounds' => [
                    'minX' => optional($icon)->min_x ?? 0,
                    'minY' => optional($icon)->min_y ?? 0,
                    'maxX' => optional($icon)->max_x ?? 0,
                    'maxY' => optional($icon)->max_y ?? 0,
                ],
                'iconClipRule' => optional($icon)->clip_rule ?? '',
                'iconFillRule' => optional($icon)->fill_rule ?? '',
                'iconSize' => optional($icon)->size ?? 20,
                'iconWidth' => 0,
                'iconHeight' => 0,
                'iconScale' => 1,
                'iconHidden' => optional($icon)->hidden ?? false,

                'initialsId' => optional($initials)->id ?? 0,
                'font' => !empty(optional($initials)->font_id) ? Font::findOrFail($initials->font_id) : [],
                'fontSize' => optional($initials)->font_size ?? 30,
                'fontBounds'=> [
                    'minX'=> 0,
                    'minY'=> 0,
                    'maxX'=> 0,
                    'maxY'=> 0,
                ],
                'fontAdvX'=> 0,
                'text' => optional($initials)->text ?? '',
                'paths'=> [],
                'letterSpace' => optional($initials)->letter_space,
                'initialsWidth'=> 0,
                'initialsHeight'=> 0,
                'initialsScale'=> 1,

                'color' => [
                    'hex' => optional($icon)->color_hex ?? (optional($initials)->color_hex ?? '#D9D525'),
                    'a' => optional($icon)->color_opacity ?? (optional($initials)->color_opacity ?? 1),
                    'rgba' => [
                        'r' => hexdec(substr(optional($icon)->color_hex ?? (optional($initials)->color_hex ?? '#D9D525'), 1, 2)),
                        'g' => hexdec(substr(optional($icon)->color_hex ?? (optional($initials)->color_hex ?? '#D9D525'), 3, 2)),
                        'b' => hexdec(substr(optional($icon)->color_hex ?? (optional($initials)->color_hex ?? '#D9D525'), 5, 2)),
                        'a' => optional($icon)->color_opacity ?? (optional($initials)->color_opacity ?? 1),
                    ],
                ],
                'lineSpace' => optional($icon)->line_space ?? (optional($initials)->line_space ?? 50)
            ];

            $container = $logo->container;
            $state['containerSettings'] = [
                'id' => optional($container)->id ?? 0,
                'types'=> [
                    [
                        'label'=> 'Filled',// also used as key of type
                        'icon'=> 'icon-certificate',
                        'selected'=> true,
                    ],
                    [
                        'label'=> 'Outlined',
                        'icon'=> 'icon-certificate-outline',
                    ],
                ],
                'list'=> [],
                'shapes'=> [],
                'color' => [
                    'hex' => optional($container)->color_hex ?? '#D9D525',
                    'rgba' => [
                        'r' => hexdec(substr(optional($container)->color_hex ?? '#D9D525', 1, 2)),
                        'g' => hexdec(substr(optional($container)->color_hex ?? '#D9D525', 3, 2)),
                        'b' => hexdec(substr(optional($container)->color_hex ?? '#D9D525', 5, 2)),
                        'a' => optional($container)->color_opacity ?? 1
                    ],
                    'a' => optional($container)->color_opacity ?? 1,
                ],
                'size' => optional($container)->size ?? 50,
                'selected' => optional($container)->container_id ? Container::findOrFail($container->container_id) : [],
                'viewBox'=> [
                    'maxX'=> 0,
                    'maxY'=> 0,
                    'minX'=> 0,
                    'minY'=> 0,
                ],
            ];

            return $state;
        });

        return $this->response([
            'status' => 'success',
            'payload' => [
                'list' => $logos,
            ],
        ], 200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');

        if (! empty($id)) {
            return $this->response([
                'status' => 'success',
                'payload' => array_values(
                    \Auth::user()->logos->filter(function($logo) use ($id) {// todo:  update code
                        return $logo->id == $id;
                    })->all()
                )
            ], 200);
        } else {
            return $this->response([
                'status' => 'success',
                'payload' => \Auth::user()->logos
            ], 200);
        }
    }

    public function getSettings(Logo $logo)
    {
        if ($logo->user_id !== \Auth::id()) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => 'The user is not authorized to get the settings',
                ],
            ], 200);
        } else {
            $state = [
                'settings' => [
                    'width'     => 1024,
                    'height'    => 768,

                    'id' => $logo->id,
                    'backgroundColor' => [
                        'hex' => $logo->bg_color
                    ],
                    'layout' => $logo->layout,
                    'scale' => $logo->scale,

                    'svg' => $logo->svg,
                ]
            ];

            $name = $logo->name;
            $state['companyNameSettings'] = [
                'id' => optional($name)->id ?? 0,
                'text' => optional($name)->text ?? '',
                'fontSize' => optional($name)->font_size ?? 20,
                'fontBounds' => [
                    'minX' => 0,
                    'minY' => 0,
                    'maxX' => 0,
                    'maxY' => 0,
                ],
                'fontAdvX' => 0,
                'letterSpace' => optional($name)->letter_space ?? 0,
                'lineSpace' => optional($name)->line_space ?? 50,
                'font' => !empty(optional($name)->font_id) ? Font::findOrFail($name->font_id) : [],
                'color' => [
                    'hex' => optional($name)->color_hex ?? '#D9D525',
                    'rgba' => [
                        'r' => hexdec(substr(optional($name)->color_hex ?? '#D9D525', 1, 2)),
                        'g' => hexdec(substr(optional($name)->color_hex ?? '#D9D525', 3, 2)),
                        'b' => hexdec(substr(optional($name)->color_hex ?? '#D9D525', 5, 2)),
                        'a' => optional($name)->color_opacity ?? 1
                    ],
                    'a' => optional($name)->color_opacity ?? 1
                ],
                'capitalization' => optional($name)->capitalization ?? '',
                'paths' => [],
                'width' => 0,
                'height' => 0,
                'scale' => 1,
            ];

            $slogan = $logo->slogan;
            $state['sloganSettings'] = [
                'id' => optional($slogan)->id ?? 0,
                'text' => optional($slogan)->text ?? '',
                'fontSize' => optional($slogan)->font_size ?? 10,
                'fontBounds' => [
                    'minX' => 0,
                    'minY' => 0,
                    'maxX' => 0,
                    'maxY' => 0,
                ],
                'fontAdvX' => 0,
                'letterSpace' => optional($slogan)->letter_space ?? 0,
                'lineSpace' => optional($slogan)->line_space ?? 0,
                'font' => !empty(optional($slogan)->font_id) ? Font::findOrFail($slogan->font_id) : [],
                'color' => [
                    'hex' => optional($slogan)->color_hex ?? '#D9D525',
                    'rgba' => [
                        'r' => hexdec(substr(optional($slogan)->color_hex ?? '#D9D525', 1, 2)),
                        'g' => hexdec(substr(optional($slogan)->color_hex ?? '#D9D525', 3, 2)),
                        'b' => hexdec(substr(optional($slogan)->color_hex ?? '#D9D525', 5, 2)),
                        'a' => optional($slogan)->color_opacity ?? 1
                    ],
                    'a' => optional($slogan)->color_opacity ?? 1
                ],
                'capitalization' => optional($slogan)->capitalization ?? '',
                'paths' => [],
                'width' => 0,
                'height' => 0,
                'scale' => 1,
            ];

            $icon = $logo->icon;
            $initials = $logo->initials;
            $state['symbolSettings'] = [
                'types' => [
                    [
                        'label'=> 'Icon',// also used as key of type
                        'icon'=> 'logobot-icon icon-gem',
                        'selected'=> strpos($logo->layout, 'initial') === false
                    ],
                    [
                        'label'=> 'Initials',
                        'icon'=> 'logobot-icon icon-heading',
                        'selected'=> strpos($logo->layout, 'initial') !== false
                    ],
                ],

                'iconId' => optional($icon)->id ?? 0,
                'tags' => optional($icon)->tags ?? [],
                'iconBounds' => [
                    'minX' => optional($icon)->min_x ?? 0,
                    'minY' => optional($icon)->min_y ?? 0,
                    'maxX' => optional($icon)->max_x ?? 0,
                    'maxY' => optional($icon)->max_y ?? 0,
                ],
                'iconClipRule' => optional($icon)->clip_rule ?? '',
                'iconFillRule' => optional($icon)->fill_rule ?? '',
                'iconSize' => optional($icon)->size ?? 20,
                'iconWidth' => 0,
                'iconHeight' => 0,
                'iconScale' => 1,
                'iconHidden' => optional($icon)->hidden ?? false,

                'initialsId' => optional($initials)->id ?? 0,
                'font' => !empty(optional($initials)->font_id) ? Font::findOrFail($initials->font_id) : [],
                'fontSize' => optional($initials)->font_size ?? 30,
                'fontBounds'=> [
                    'minX'=> 0,
                    'minY'=> 0,
                    'maxX'=> 0,
                    'maxY'=> 0,
                ],
                'fontAdvX'=> 0,
                'text' => optional($initials)->text ?? '',
                'paths'=> [],
                'letterSpace' => optional($initials)->letter_space,
                'initialsWidth'=> 0,
                'initialsHeight'=> 0,
                'initialsScale'=> 1,

                'color' => [
                    'hex' => optional($icon)->color_hex ?? (optional($initials)->color_hex ?? '#D9D525'),
                    'a' => optional($icon)->color_opacity ?? (optional($initials)->color_opacity ?? 1),
                    'rgba' => [
                        'r' => hexdec(substr(optional($icon)->color_hex ?? (optional($initials)->color_hex ?? '#D9D525'), 1, 2)),
                        'g' => hexdec(substr(optional($icon)->color_hex ?? (optional($initials)->color_hex ?? '#D9D525'), 3, 2)),
                        'b' => hexdec(substr(optional($icon)->color_hex ?? (optional($initials)->color_hex ?? '#D9D525'), 5, 2)),
                        'a' => optional($icon)->color_opacity ?? (optional($initials)->color_opacity ?? 1),
                    ],
                ],
                'lineSpace' => optional($icon)->line_space ?? (optional($initials)->line_space ?? 50)
            ];

            $container = $logo->container;
            $state['containerSettings'] = [
                'id' => optional($container)->id ?? 0,
                'types'=> [
                    [
                        'label'=> 'Filled',// also used as key of type
                        'icon'=> 'icon-certificate',
                        'selected'=> true,
                    ],
                    [
                        'label'=> 'Outlined',
                        'icon'=> 'icon-certificate-outline',
                    ],
                ],
                'list'=> [],
                'shapes'=> [],
                'color' => [
                    'hex' => optional($container)->color_hex ?? '#D9D525',
                    'rgba' => [
                        'r' => hexdec(substr(optional($container)->color_hex ?? '#D9D525', 1, 2)),
                        'g' => hexdec(substr(optional($container)->color_hex ?? '#D9D525', 3, 2)),
                        'b' => hexdec(substr(optional($container)->color_hex ?? '#D9D525', 5, 2)),
                        'a' => optional($container)->color_opacity ?? 1
                    ],
                    'a' => optional($container)->color_opacity ?? 1,
                ],
                'size' => optional($container)->size ?? 50,
                'selected' => optional($container)->container_id ? Container::findOrFail($container->container_id) : [],
                'viewBox'=> [
                    'maxX'=> 0,
                    'maxY'=> 0,
                    'minX'=> 0,
                    'minY'=> 0,
                ],
            ];

            return $this->response([
                'status' => 'success',
                'payload' => $state
            ], 200);
        }
    }
}
