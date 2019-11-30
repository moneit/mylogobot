<?php

use Illuminate\Database\Seeder;
use App\Palette;
use App\ColorCategory;

class ColorCategoryPaletteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('color_category_palette')->delete();

        $colorCategoryClean = ColorCategory::where('name', 'Clean')->first();
        $palettesForClean = [
            [ 'bg_color' => '#B1655E', 'company_name_color' => '#F3F3F4' ],
            [ 'bg_color' => '#DC2F2F', 'company_name_color' => '#CDCAC5' ],
            [ 'bg_color' => '#DC3446', 'company_name_color' => '#E7E2E5' ],
            [ 'bg_color' => '#AA0626', 'company_name_color' => '#E8664F' ],
            [ 'bg_color' => '#B60C28', 'company_name_color' => '#F06440' ],
            [ 'bg_color' => '#FAFAEA', 'company_name_color' => '#E92132' ],
            [ 'bg_color' => '#C8C7C4', 'company_name_color' => '#F01414' ],
            [ 'bg_color' => '#E77024', 'company_name_color' => '#F0B538' ],
            [ 'bg_color' => '#E3E7E4', 'company_name_color' => '#AD561D' ],
            [ 'bg_color' => '#DE7532', 'company_name_color' => '#FFFFFF' ],
            [ 'bg_color' => '#FFFFFF', 'company_name_color' => '#DE7532' ],
            [ 'bg_color' => '#EE6F19', 'company_name_color' => '#961F25' ],
            [ 'bg_color' => '#F6670D', 'company_name_color' => '#FEFEFE' ],
            [ 'bg_color' => '#000000', 'company_name_color' => '#FF7E0B' ],
            [ 'bg_color' => '#F26D16', 'company_name_color' => '#F8B32A' ],
            [ 'bg_color' => '#E7C339', 'company_name_color' => '#BE210D' ],
            [ 'bg_color' => '#179483', 'company_name_color' => '#F7CD0C' ],
            [ 'bg_color' => '#EFF242', 'company_name_color' => '#08ACFF' ],
            [ 'bg_color' => '#F8E324', 'company_name_color' => '#967555' ],
            [ 'bg_color' => '#F4C508', 'company_name_color' => '#833D30' ],
            [ 'bg_color' => '#15181B', 'company_name_color' => '#F8F616' ],
            [ 'bg_color' => '#F8F7F4', 'company_name_color' => '#F5D261' ],
            [ 'bg_color' => '#6EB32E', 'company_name_color' => '#3B4938' ],
            [ 'bg_color' => '#13CB42', 'company_name_color' => '#104361' ],
            [ 'bg_color' => '#48A23C', 'company_name_color' => '#EDCC08' ],
            [ 'bg_color' => '#6EBA49', 'company_name_color' => '#3D75A2' ],
            [ 'bg_color' => '#0A3E28', 'company_name_color' => '#4BB967' ],
            [ 'bg_color' => '#179483', 'company_name_color' => '#F7CD0C' ],
            [ 'bg_color' => '#555740', 'company_name_color' => '#9BCF3C' ],
            [ 'bg_color' => '#93DDA4', 'company_name_color' => '#00232B' ],
            [ 'bg_color' => '#A0CF4C', 'company_name_color' => '#265253' ],
            [ 'bg_color' => '#E6A4A6', 'company_name_color' => '#071135' ],
            [ 'bg_color' => '#0791E0', 'company_name_color' => '#2E3037' ],
            [ 'bg_color' => '#F3F5F3', 'company_name_color' => '#436F86' ],
            [ 'bg_color' => '#1AA7F7', 'company_name_color' => '#83D785' ],
            [ 'bg_color' => '#23A8F6', 'company_name_color' => '#F4F3EC' ],
            [ 'bg_color' => '#4681C7', 'company_name_color' => '#3DB8AC' ],
            [ 'bg_color' => '#6FB9C3', 'company_name_color' => '#F8F6EF' ],
            [ 'bg_color' => '#13CB42', 'company_name_color' => '#104361' ],
            [ 'bg_color' => '#6EBA49', 'company_name_color' => '#3D75A2' ],
            [ 'bg_color' => '#00D2AD', 'company_name_color' => '#373C51' ],
            [ 'bg_color' => '#E3D5E5', 'company_name_color' => '#3351C7' ],
            [ 'bg_color' => '#170E59', 'company_name_color' => '#DEBCEC' ],
            [ 'bg_color' => '#3C1D55', 'company_name_color' => '#B86386' ],
            [ 'bg_color' => '#EDF1F3', 'company_name_color' => '#554786' ],
            [ 'bg_color' => '#E0DBD9', 'company_name_color' => '#300F38' ],
            [ 'bg_color' => '#694E7D', 'company_name_color' => '#DED9CF' ],
            [ 'bg_color' => '#300F38', 'company_name_color' => '#E0DBD9' ],
            [ 'bg_color' => '#DCA6D7', 'company_name_color' => '#523395' ],
            [ 'bg_color' => '#350633', 'company_name_color' => '#DF1867' ],
            [ 'bg_color' => '#841621', 'company_name_color' => '#DC5F98' ],
            [ 'bg_color' => '#DC3446', 'company_name_color' => '#E7E2E5' ],
            [ 'bg_color' => '#DE3973', 'company_name_color' => '#DBFCD5' ],
            [ 'bg_color' => '#F1FFFF', 'company_name_color' => '#FF2836' ],
            [ 'bg_color' => '#E6A4A6', 'company_name_color' => '#071135' ],
            [ 'bg_color' => '#CE6770', 'company_name_color' => '#F9BCAA' ],
            [ 'bg_color' => '#E886AB', 'company_name_color' => '#E32055' ],
            [ 'bg_color' => '#344734', 'company_name_color' => '#659749' ],
            [ 'bg_color' => '#4C6046', 'company_name_color' => '#B2CCBB' ],
            [ 'bg_color' => '#415A47', 'company_name_color' => '#BCD4CD' ],
            [ 'bg_color' => '#2E3037', 'company_name_color' => '#0791E0' ],
            [ 'bg_color' => '#373940', 'company_name_color' => '#A29572' ],
            [ 'bg_color' => '#333032', 'company_name_color' => '#C18158' ],
            [ 'bg_color' => '#BCD4CD', 'company_name_color' => '#415A47' ],
            [ 'bg_color' => '#15181B', 'company_name_color' => '#F8F616' ],
        ];

        foreach($palettesForClean as $paletteForClean) {
            $palette = Palette::where('bg_color', $paletteForClean['bg_color'])
                ->where('company_name_color', $paletteForClean['company_name_color'])
                ->first();
            $palette->colorCategory()->attach($colorCategoryClean);
        }

        $colorCategoryVibrant = ColorCategory::where('name', 'Vibrant')->first();
        $palettesForVibrant = [
            [ 'bg_color' => '#841621', 'company_name_color' => '#DC5F98' ],
            [ 'bg_color' => '#580708', 'company_name_color' => '#F50D1B' ],
            [ 'bg_color' => '#8B0D19', 'company_name_color' => '#E64E93' ],
            [ 'bg_color' => '#CA2A26', 'company_name_color' => '#1CB4F8' ],
            [ 'bg_color' => '#520D0C', 'company_name_color' => '#DF2932' ],
            [ 'bg_color' => '#E70300', 'company_name_color' => '#F4C800' ],
            [ 'bg_color' => '#2D3841', 'company_name_color' => '#F79209' ],
            [ 'bg_color' => '#F75C0D', 'company_name_color' => '#5E258A' ],
            [ 'bg_color' => '#EC5C18', 'company_name_color' => '#000000' ],
            [ 'bg_color' => '#F6670D', 'company_name_color' => '#FEFEFE' ],
            [ 'bg_color' => '#F86400', 'company_name_color' => '#FFAE0F' ],
            [ 'bg_color' => '#FF6503', 'company_name_color' => '#D4DC0D' ],
            [ 'bg_color' => '#F5F018', 'company_name_color' => '#1E1C1A' ],
            [ 'bg_color' => '#EAC633', 'company_name_color' => '#BB1706' ],
            [ 'bg_color' => '#FCFC00', 'company_name_color' => '#00407B' ],
            [ 'bg_color' => '#F7A30C', 'company_name_color' => '#C76723' ],
            [ 'bg_color' => '#F7C90E', 'company_name_color' => '#B1268B' ],
            [ 'bg_color' => '#F1CF0F', 'company_name_color' => '#DE1956' ],
            [ 'bg_color' => '#FDC600', 'company_name_color' => '#BA2480' ],
            [ 'bg_color' => '#FF6503', 'company_name_color' => '#D4DC0D' ],
            [ 'bg_color' => '#07CD47', 'company_name_color' => '#035225' ],
            [ 'bg_color' => '#13CB42', 'company_name_color' => '#104361' ],
            [ 'bg_color' => '#1ECE12', 'company_name_color' => '#1A6947' ],
            [ 'bg_color' => '#0DF76B', 'company_name_color' => '#610986' ],
            [ 'bg_color' => '#92DE27', 'company_name_color' => '#DE4959' ],
            [ 'bg_color' => '#29321F', 'company_name_color' => '#94D830' ],
            [ 'bg_color' => '#00F69E', 'company_name_color' => '#072118' ],
            [ 'bg_color' => '#2C196F', 'company_name_color' => '#13CDDA' ],
            [ 'bg_color' => '#0791E0', 'company_name_color' => '#2E3037' ],
            [ 'bg_color' => '#23A8F6', 'company_name_color' => '#F4F3EC' ],
            [ 'bg_color' => '#3280C2', 'company_name_color' => '#2EC2CC' ],
            [ 'bg_color' => '#0896E6', 'company_name_color' => '#F9C348' ],
            [ 'bg_color' => '#CA2A26', 'company_name_color' => '#1CB4F8' ],
            [ 'bg_color' => '#CC436A', 'company_name_color' => '#0E304E' ],
            [ 'bg_color' => '#13CB42', 'company_name_color' => '#104361' ],
            [ 'bg_color' => '#00D2AD', 'company_name_color' => '#373C51' ],
            [ 'bg_color' => '#43294C', 'company_name_color' => '#57C4DA' ],
            [ 'bg_color' => '#776FB8', 'company_name_color' => '#0AD1BA' ],
            [ 'bg_color' => '#4D209F', 'company_name_color' => '#E683D5' ],
            [ 'bg_color' => '#771CEC', 'company_name_color' => '#5CE0B9' ],
            [ 'bg_color' => '#F75C0D', 'company_name_color' => '#5E258A' ],
            [ 'bg_color' => '#8D0A72', 'company_name_color' => '#F82A71' ],
            [ 'bg_color' => '#6B0AF7', 'company_name_color' => '#E8EC07' ],
            [ 'bg_color' => '#350633', 'company_name_color' => '#DF1867' ],
            [ 'bg_color' => '#F7094F', 'company_name_color' => '#06C461' ],
            [ 'bg_color' => '#E55376', 'company_name_color' => '#5B1D39' ],
            [ 'bg_color' => '#D12E58', 'company_name_color' => '#E2DAC1' ],
            [ 'bg_color' => '#8B0D19', 'company_name_color' => '#E64E93' ],
            [ 'bg_color' => '#CC436A', 'company_name_color' => '#0E304E' ],
            [ 'bg_color' => '#DDFFF2', 'company_name_color' => '#D24084' ],
            [ 'bg_color' => '#DE1956', 'company_name_color' => '#F1CF0F' ],
            [ 'bg_color' => '#350633', 'company_name_color' => '#DF1867' ],
            [ 'bg_color' => '#CD03DC', 'company_name_color' => '#5C0A8D' ],
            [ 'bg_color' => '#1E1C1A', 'company_name_color' => '#F5F018' ],
            [ 'bg_color' => '#29321F', 'company_name_color' => '#94D830' ],
            [ 'bg_color' => '#2D3841', 'company_name_color' => '#F79209' ],
            [ 'bg_color' => '#072118', 'company_name_color' => '#00F69E' ],
        ];

        foreach($palettesForVibrant as $paletteForVibrant) {
            $palette = Palette::where('bg_color', $paletteForVibrant['bg_color'])
                ->where('company_name_color', $paletteForVibrant['company_name_color'])
                ->first();
            $palette->colorCategory()->attach($colorCategoryVibrant);
        }

        $colorCategoryWarm = ColorCategory::where('name', 'Warm')->first();
        $palettesForWarm = [
            [ 'bg_color' => '#DC2F2F', 'company_name_color' => '#CDCAC5' ],
            [ 'bg_color' => '#591612', 'company_name_color' => '#DC393F' ],
            [ 'bg_color' => '#AA0626', 'company_name_color' => '#E8664F' ],
            [ 'bg_color' => '#B60C28', 'company_name_color' => '#F06440' ],
            [ 'bg_color' => '#C8C7C4', 'company_name_color' => '#F01414' ],
            [ 'bg_color' => '#5D1B16', 'company_name_color' => '#DD3D40' ],
            [ 'bg_color' => '#E70300', 'company_name_color' => '#F4C800' ],
            [ 'bg_color' => '#F6A029', 'company_name_color' => '#B92E0A' ],
            [ 'bg_color' => '#2D3841', 'company_name_color' => '#F79209' ],
            [ 'bg_color' => '#E77024', 'company_name_color' => '#F0B538' ],
            [ 'bg_color' => '#7D2904', 'company_name_color' => '#F37608' ],
            [ 'bg_color' => '#EE6F19', 'company_name_color' => '#961F25' ],
            [ 'bg_color' => '#000000', 'company_name_color' => '#FF7E0B' ],
            [ 'bg_color' => '#F26D16', 'company_name_color' => '#F8B32A' ],
            [ 'bg_color' => '#F86400', 'company_name_color' => '#FFAE0F' ],
            [ 'bg_color' => '#F8E324', 'company_name_color' => '#967555' ],
            [ 'bg_color' => '#F7A30C', 'company_name_color' => '#C76723' ],
            [ 'bg_color' => '#F8F616', 'company_name_color' => '#15181B' ],
            [ 'bg_color' => '#F4C508', 'company_name_color' => '#833D30' ],
            [ 'bg_color' => '#CA2A26', 'company_name_color' => '#1CB4F8' ],
            [ 'bg_color' => '#443A33', 'company_name_color' => '#D67738' ],
            [ 'bg_color' => '#08060D', 'company_name_color' => '#C09A59' ],
        ];

        foreach($palettesForWarm as $paletteForWarm) {
            $palette = Palette::where('bg_color', $paletteForWarm['bg_color'])
                ->where('company_name_color', $paletteForWarm['company_name_color'])
                ->first();
            $palette->colorCategory()->attach($colorCategoryWarm);
        }

        $colorCategoryDark = ColorCategory::where('name', 'Dark')->first();
        $palettesForDark = [
            [ 'bg_color' => '#591612', 'company_name_color' => '#DC393F' ],
            [ 'bg_color' => '#441013', 'company_name_color' => '#C7515C' ],
            [ 'bg_color' => '#8B0D19', 'company_name_color' => '#E64E93' ],
            [ 'bg_color' => '#5D1B16', 'company_name_color' => '#DD3D40' ],
            [ 'bg_color' => '#520D0C', 'company_name_color' => '#DF2932' ],
            [ 'bg_color' => '#7D2904', 'company_name_color' => '#F37608' ],
            [ 'bg_color' => '#1E0E01', 'company_name_color' => '#F08925' ],
            [ 'bg_color' => '#0A3E28', 'company_name_color' => '#4BB967' ],
            [ 'bg_color' => '#024627', 'company_name_color' => '#3DC058' ],
            [ 'bg_color' => '#29321F', 'company_name_color' => '#94D830' ],
            [ 'bg_color' => '#555740', 'company_name_color' => '#9BCF3C' ],
            [ 'bg_color' => '#00F69E', 'company_name_color' => '#072118' ],
            [ 'bg_color' => '#E6A4A6', 'company_name_color' => '#071135' ],
            [ 'bg_color' => '#2C196F', 'company_name_color' => '#13CDDA' ],
            [ 'bg_color' => '#4681C7', 'company_name_color' => '#3DB8AC' ],
            [ 'bg_color' => '#CC436A', 'company_name_color' => '#0E304E' ],
            [ 'bg_color' => '#170E59', 'company_name_color' => '#DEBCEC' ],
            [ 'bg_color' => '#3C1D55', 'company_name_color' => '#B86386' ],
            [ 'bg_color' => '#694E7D', 'company_name_color' => '#DED9CF' ],
            [ 'bg_color' => '#300F38', 'company_name_color' => '#E0DBD9' ],
            [ 'bg_color' => '#350633', 'company_name_color' => '#DF1867' ],
            [ 'bg_color' => '#841621', 'company_name_color' => '#DC5F98' ],
            [ 'bg_color' => '#E55376', 'company_name_color' => '#5B1D39' ],
            [ 'bg_color' => '#8B0D19', 'company_name_color' => '#E64E93' ],
            [ 'bg_color' => '#350633', 'company_name_color' => '#DF1867' ],
            [ 'bg_color' => '#1E1C1A', 'company_name_color' => '#F5F018' ],
            [ 'bg_color' => '#344734', 'company_name_color' => '#659749' ],
            [ 'bg_color' => '#4C6046', 'company_name_color' => '#B2CCBB' ],
            [ 'bg_color' => '#29321F', 'company_name_color' => '#94D830' ],
            [ 'bg_color' => '#2D3841', 'company_name_color' => '#F79209' ],
            [ 'bg_color' => '#415A47', 'company_name_color' => '#BCD4CD' ],
            [ 'bg_color' => '#2E3037', 'company_name_color' => '#0791E0' ],
            [ 'bg_color' => '#443A33', 'company_name_color' => '#D67738' ],
            [ 'bg_color' => '#373940', 'company_name_color' => '#A29572' ],
            [ 'bg_color' => '#333032', 'company_name_color' => '#C18158' ],
            [ 'bg_color' => '#293443', 'company_name_color' => '#9F9E90' ],
            [ 'bg_color' => '#BCD4CD', 'company_name_color' => '#415A47' ],
            [ 'bg_color' => '#08060D', 'company_name_color' => '#C09A59' ],
            [ 'bg_color' => '#101A29', 'company_name_color' => '#686C6E' ],
            [ 'bg_color' => '#072118', 'company_name_color' => '#00F69E' ],
            [ 'bg_color' => '#15181B', 'company_name_color' => '#F8F616' ],
        ];

        foreach($palettesForDark as $paletteForDark) {
            $palette = Palette::where('bg_color', $paletteForDark['bg_color'])
                ->where('company_name_color', $paletteForDark['company_name_color'])
                ->first();
            $palette->colorCategory()->attach($colorCategoryDark);
        }
    }
}
