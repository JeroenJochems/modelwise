<?php

namespace App\ViewModels;

use PrinsFrank\Standards\Country\CountryAlpha3;
use PrinsFrank\Standards\CountryCallingCode\CountryCallingCode;
use Spatie\ViewModels\ViewModel;

/** @typescript */
class CountriesViewModel extends ViewModel
{
    /** @var array<Country> */
    public array $countries;

    public function __construct()
    {
        $this->countries = collect($this->countryArray)
            ->map(function ($country) {
                return new Country(
                    $country['name'],
                    $country['code'],
                    $country['phone'],
                );
            })
            ->toArray();
    }

    private $countryArray = [
        ["name" => "Afghanistan", "code" => "AF", "phone" => 93, "alpha_3" => "AFG"],
        ["name" => "Aland Islands", "code" => "AX", "phone" => 358, "alpha_3" => "ALA"],
        ["name" => "Albania", "code" => "AL", "phone" => 355, "alpha_3" => "ALB"],
        ["name" => "Algeria", "code" => "DZ", "phone" => 213, "alpha_3" => "DZA"],
        ["name" => "American Samoa", "code" => "AS", "phone" => 1684, "alpha_3" => "ASM"],
        ["name" => "Andorra", "code" => "AD", "phone" => 376, "alpha_3" => "AND"],
        ["name" => "Angola", "code" => "AO", "phone" => 244, "alpha_3" => "AGO"],
        ["name" => "Anguilla", "code" => "AI", "phone" => 1264, "alpha_3" => "AIA"],
        ["name" => "Antarctica", "code" => "AQ", "phone" => 672, "alpha_3" => "ATA"],
        ["name" => "Antigua and Barbuda", "code" => "AG", "phone" => 1268, "alpha_3" => "ATG"],
        ["name" => "Argentina", "code" => "AR", "phone" => 54, "alpha_3" => "ARG"],
        ["name" => "Armenia", "code" => "AM", "phone" => 374, "alpha_3" => "ARM"],
        ["name" => "Aruba", "code" => "AW", "phone" => 297, "alpha_3" => "ABW"],
        ["name" => "Australia", "code" => "AU", "phone" => 61, "alpha_3" => "AUS"],
        ["name" => "Austria", "code" => "AT", "phone" => 43, "alpha_3" => "AUT"],
        ["name" => "Azerbaijan", "code" => "AZ", "phone" => 994, "alpha_3" => "AZE"],
        ["name" => "Bahamas", "code" => "BS", "phone" => 1242, "alpha_3" => "BHS"],
        ["name" => "Bahrain", "code" => "BH", "phone" => 973, "alpha_3" => "BHR"],
        ["name" => "Bangladesh", "code" => "BD", "phone" => 880, "alpha_3" => "BGD"],
        ["name" => "Barbados", "code" => "BB", "phone" => 1246, "alpha_3" => "BRB"],
        ["name" => "Belarus", "code" => "BY", "phone" => 375, "alpha_3" => "BLR"],
        ["name" => "Belgium", "code" => "BE", "phone" => 32, "alpha_3" => "BEL"],
        ["name" => "Belize", "code" => "BZ", "phone" => 501, "alpha_3" => "BLZ"],
        ["name" => "Benin", "code" => "BJ", "phone" => 229, "alpha_3" => "BEN"],
        ["name" => "Bermuda", "code" => "BM", "phone" => 1441, "alpha_3" => "BMU"],
        ["name" => "Bhutan", "code" => "BT", "phone" => 975, "alpha_3" => "BTN"],
        ["name" => "Bolivia", "code" => "BO", "phone" => 591, "alpha_3" => "BOL"],
        ["name" => "Bonaire, Sint Eustatius and Saba", "code" => "BQ", "phone" => 599, "alpha_3" => "BES"],
        ["name" => "Bosnia and Herzegovina", "code" => "BA", "phone" => 387, "alpha_3" => "BIH"],
        ["name" => "Botswana", "code" => "BW", "phone" => 267, "alpha_3" => "BWA"],
        ["name" => "Bouvet Island", "code" => "BV", "phone" => 55, "alpha_3" => "BVT"],
        ["name" => "Brazil", "code" => "BR", "phone" => 55, "alpha_3" => "BRA"],
        ["name" => "British Indian Ocean Territory", "code" => "IO", "phone" => 246, "alpha_3" => "IOT"],
        ["name" => "Brunei Darussalam", "code" => "BN", "phone" => 673, "alpha_3" => "BRN"],
        ["name" => "Bulgaria", "code" => "BG", "phone" => 359, "alpha_3" => "BGR"],
        ["name" => "Burkina Faso", "code" => "BF", "phone" => 226, "alpha_3" => "BFA"],
        ["name" => "Burundi", "code" => "BI", "phone" => 257, "alpha_3" => "BDI"],
        ["name" => "Cambodia", "code" => "KH", "phone" => 855, "alpha_3" => "KHM"],
        ["name" => "Cameroon", "code" => "CM", "phone" => 237, "alpha_3" => "CMR"],
        ["name" => "Canada", "code" => "CA", "phone" => 1, "alpha_3" => "CAN"],
        ["name" => "Cape Verde", "code" => "CV", "phone" => 238, "alpha_3" => "CPV"],
        ["name" => "Cayman Islands", "code" => "KY", "phone" => 1345, "alpha_3" => "CYM"],
        ["name" => "Central African Republic", "code" => "CF", "phone" => 236, "alpha_3" => "CAF"],
        ["name" => "Chad", "code" => "TD", "phone" => 235, "alpha_3" => "TCD"],
        ["name" => "Chile", "code" => "CL", "phone" => 56, "alpha_3" => "CHL"],
        ["name" => "China", "code" => "CN", "phone" => 86, "alpha_3" => "CHN"],
        ["name" => "Christmas Island", "code" => "CX", "phone" => 61, "alpha_3" => "CXR"],
        ["name" => "Cocos (Keeling) Islands", "code" => "CC", "phone" => 672, "alpha_3" => "CCK"],
        ["name" => "Colombia", "code" => "CO", "phone" => 57, "alpha_3" => "COL"],
        ["name" => "Comoros", "code" => "KM", "phone" => 269, "alpha_3" => "COM"],
        ["name" => "Congo", "code" => "CG", "phone" => 242, "alpha_3" => "COG"],
        ["name" => "Congo, Democratic Republic of the Congo", "code" => "CD", "phone" => 242, "alpha_3" => "COD"],
        ["name" => "Cook Islands", "code" => "CK", "phone" => 682, "alpha_3" => "COK"],
        ["name" => "Costa Rica", "code" => "CR", "phone" => 506, "alpha_3" => "CRI"],
        ["name" => "Cote D'Ivoire", "code" => "CI", "phone" => 225, "alpha_3" => "CIV"],
        ["name" => "Croatia", "code" => "HR", "phone" => 385, "alpha_3" => "HRV"],
        ["name" => "Cuba", "code" => "CU", "phone" => 53, "alpha_3" => "CUB"],
        ["name" => "Curacao", "code" => "CW", "phone" => 599, "alpha_3" => "CUW"],
        ["name" => "Cyprus", "code" => "CY", "phone" => 357, "alpha_3" => "CYP"],
        ["name" => "Czech Republic", "code" => "CZ", "phone" => 420, "alpha_3" => "CZE"],
        ["name" => "Denmark", "code" => "DK", "phone" => 45, "alpha_3" => "DNK"],
        ["name" => "Djibouti", "code" => "DJ", "phone" => 253, "alpha_3" => "DJI"],
        ["name" => "Dominica", "code" => "DM", "phone" => 1767, "alpha_3" => "DMA"],
        ["name" => "Dominican Republic", "code" => "DO", "phone" => 1809, "alpha_3" => "DOM"],
        ["name" => "Ecuador", "code" => "EC", "phone" => 593, "alpha_3" => "ECU"],
        ["name" => "Egypt", "code" => "EG", "phone" => 20, "alpha_3" => "EGY"],
        ["name" => "El Salvador", "code" => "SV", "phone" => 503, "alpha_3" => "SLV"],
        ["name" => "Equatorial Guinea", "code" => "GQ", "phone" => 240, "alpha_3" => "GNQ"],
        ["name" => "Eritrea", "code" => "ER", "phone" => 291, "alpha_3" => "ERI"],
        ["name" => "Estonia", "code" => "EE", "phone" => 372, "alpha_3" => "EST"],
        ["name" => "Ethiopia", "code" => "ET", "phone" => 251, "alpha_3" => "ETH"],
        ["name" => "Falkland Islands (Malvinas)", "code" => "FK", "phone" => 500, "alpha_3" => "FLK"],
        ["name" => "Faroe Islands", "code" => "FO", "phone" => 298, "alpha_3" => "FRO"],
        ["name" => "Fiji", "code" => "FJ", "phone" => 679, "alpha_3" => "FJI"],
        ["name" => "Finland", "code" => "FI", "phone" => 358, "alpha_3" => "FIN"],
        ["name" => "France", "code" => "FR", "phone" => 33, "alpha_3" => "FRA"],
        ["name" => "French Guiana", "code" => "GF", "phone" => 594, "alpha_3" => "GUF"],
        ["name" => "French Polynesia", "code" => "PF", "phone" => 689, "alpha_3" => "PYF"],
        ["name" => "French Southern Territories", "code" => "TF", "phone" => 262, "alpha_3" => "ATF"],
        ["name" => "Gabon", "code" => "GA", "phone" => 241, "alpha_3" => "GAB"],
        ["name" => "Gambia", "code" => "GM", "phone" => 220, "alpha_3" => "GMB"],
        ["name" => "Georgia", "code" => "GE", "phone" => 995, "alpha_3" => "GEO"],
        ["name" => "Germany", "code" => "DE", "phone" => 49, "alpha_3" => "DEU"],
        ["name" => "Ghana", "code" => "GH", "phone" => 233, "alpha_3" => "GHA"],
        ["name" => "Gibraltar", "code" => "GI", "phone" => 350, "alpha_3" => "GIB"],
        ["name" => "Greece", "code" => "GR", "phone" => 30, "alpha_3" => "GRC"],
        ["name" => "Greenland", "code" => "GL", "phone" => 299, "alpha_3" => "GRL"],
        ["name" => "Grenada", "code" => "GD", "phone" => 1473, "alpha_3" => "GRD"],
        ["name" => "Guadeloupe", "code" => "GP", "phone" => 590, "alpha_3" => "GLP"],
        ["name" => "Guam", "code" => "GU", "phone" => 1671, "alpha_3" => "GUM"],
        ["name" => "Guatemala", "code" => "GT", "phone" => 502, "alpha_3" => "GTM"],
        ["name" => "Guernsey", "code" => "GG", "phone" => 44, "alpha_3" => "GGY"],
        ["name" => "Guinea", "code" => "GN", "phone" => 224, "alpha_3" => "GIN"],
        ["name" => "Guinea-Bissau", "code" => "GW", "phone" => 245, "alpha_3" => "GNB"],
        ["name" => "Guyana", "code" => "GY", "phone" => 592, "alpha_3" => "GUY"],
        ["name" => "Haiti", "code" => "HT", "phone" => 509, "alpha_3" => "HTI"],
        ["name" => "Heard Island and McDonald Islands", "code" => "HM", "phone" => 0, "alpha_3" => "HMD"],
        ["name" => "Holy See (Vatican City State)", "code" => "VA", "phone" => 39, "alpha_3" => "VAT"],
        ["name" => "Honduras", "code" => "HN", "phone" => 504, "alpha_3" => "HND"],
        ["name" => "Hong Kong", "code" => "HK", "phone" => 852, "alpha_3" => "HKG"],
        ["name" => "Hungary", "code" => "HU", "phone" => 36, "alpha_3" => "HUN"],
        ["name" => "Iceland", "code" => "IS", "phone" => 354, "alpha_3" => "ISL"],
        ["name" => "India", "code" => "IN", "phone" => 91, "alpha_3" => "IND"],
        ["name" => "Indonesia", "code" => "ID", "phone" => 62, "alpha_3" => "IDN"],
        ["name" => "Iran, Islamic Republic of", "code" => "IR", "phone" => 98, "alpha_3" => "IRN"],
        ["name" => "Iraq", "code" => "IQ", "phone" => 964, "alpha_3" => "IRQ"],
        ["name" => "Ireland", "code" => "IE", "phone" => 353, "alpha_3" => "IRL"],
        ["name" => "Isle of Man", "code" => "IM", "phone" => 44, "alpha_3" => "IMN"],
        ["name" => "Israel", "code" => "IL", "phone" => 972, "alpha_3" => "ISR"],
        ["name" => "Italy", "code" => "IT", "phone" => 39, "alpha_3" => "ITA"],
        ["name" => "Jamaica", "code" => "JM", "phone" => 1876, "alpha_3" => "JAM"],
        ["name" => "Japan", "code" => "JP", "phone" => 81, "alpha_3" => "JPN"],
        ["name" => "Jersey", "code" => "JE", "phone" => 44, "alpha_3" => "JEY"],
        ["name" => "Jordan", "code" => "JO", "phone" => 962, "alpha_3" => "JOR"],
        ["name" => "Kazakhstan", "code" => "KZ", "phone" => 7, "alpha_3" => "KAZ"],
        ["name" => "Kenya", "code" => "KE", "phone" => 254, "alpha_3" => "KEN"],
        ["name" => "Kiribati", "code" => "KI", "phone" => 686, "alpha_3" => "KIR"],
        ["name" => "Korea, Democratic People's Republic of", "code" => "KP", "phone" => 850, "alpha_3" => "PRK"],
        ["name" => "Korea, Republic of", "code" => "KR", "phone" => 82, "alpha_3" => "KOR"],
        ["name" => "Kosovo", "code" => "XK", "phone" => 383, "alpha_3" => "XKX"],
        ["name" => "Kuwait", "code" => "KW", "phone" => 965, "alpha_3" => "KWT"],
        ["name" => "Kyrgyzstan", "code" => "KG", "phone" => 996, "alpha_3" => "KGZ"],
        ["name" => "Lao People's Democratic Republic", "code" => "LA", "phone" => 856, "alpha_3" => "LAO"],
        ["name" => "Latvia", "code" => "LV", "phone" => 371, "alpha_3" => "LVA"],
        ["name" => "Lebanon", "code" => "LB", "phone" => 961, "alpha_3" => "LBN"],
        ["name" => "Lesotho", "code" => "LS", "phone" => 266, "alpha_3" => "LSO"],
        ["name" => "Liberia", "code" => "LR", "phone" => 231, "alpha_3" => "LBR"],
        ["name" => "Libyan Arab Jamahiriya", "code" => "LY", "phone" => 218, "alpha_3" => "LBY"],
        ["name" => "Liechtenstein", "code" => "LI", "phone" => 423, "alpha_3" => "LIE"],
        ["name" => "Lithuania", "code" => "LT", "phone" => 370, "alpha_3" => "LTU"],
        ["name" => "Luxembourg", "code" => "LU", "phone" => 352, "alpha_3" => "LUX"],
        ["name" => "Macao", "code" => "MO", "phone" => 853, "alpha_3" => "MAC"],
        ["name" => "Macedonia, the Former Yugoslav Republic of", "code" => "MK", "phone" => 389, "alpha_3" => "MKD"],
        ["name" => "Madagascar", "code" => "MG", "phone" => 261, "alpha_3" => "MDG"],
        ["name" => "Malawi", "code" => "MW", "phone" => 265, "alpha_3" => "MWI"],
        ["name" => "Malaysia", "code" => "MY", "phone" => 60, "alpha_3" => "MYS"],
        ["name" => "Maldives", "code" => "MV", "phone" => 960, "alpha_3" => "MDV"],
        ["name" => "Mali", "code" => "ML", "phone" => 223, "alpha_3" => "MLI"],
        ["name" => "Malta", "code" => "MT", "phone" => 356, "alpha_3" => "MLT"],
        ["name" => "Marshall Islands", "code" => "MH", "phone" => 692, "alpha_3" => "MHL"],
        ["name" => "Martinique", "code" => "MQ", "phone" => 596, "alpha_3" => "MTQ"],
        ["name" => "Mauritania", "code" => "MR", "phone" => 222, "alpha_3" => "MRT"],
        ["name" => "Mauritius", "code" => "MU", "phone" => 230, "alpha_3" => "MUS"],
        ["name" => "Mayotte", "code" => "YT", "phone" => 262, "alpha_3" => "MYT"],
        ["name" => "Mexico", "code" => "MX", "phone" => 52, "alpha_3" => "MEX"],
        ["name" => "Micronesia, Federated States of", "code" => "FM", "phone" => 691, "alpha_3" => "FSM"],
        ["name" => "Moldova, Republic of", "code" => "MD", "phone" => 373, "alpha_3" => "MDA"],
        ["name" => "Monaco", "code" => "MC", "phone" => 377, "alpha_3" => "MCO"],
        ["name" => "Mongolia", "code" => "MN", "phone" => 976, "alpha_3" => "MNG"],
        ["name" => "Montenegro", "code" => "ME", "phone" => 382, "alpha_3" => "MNE"],
        ["name" => "Montserrat", "code" => "MS", "phone" => 1664, "alpha_3" => "MSR"],
        ["name" => "Morocco", "code" => "MA", "phone" => 212, "alpha_3" => "MAR"],
        ["name" => "Mozambique", "code" => "MZ", "phone" => 258, "alpha_3" => "MOZ"],
        ["name" => "Myanmar", "code" => "MM", "phone" => 95, "alpha_3" => "MMR"],
        ["name" => "Namibia", "code" => "NA", "phone" => 264, "alpha_3" => "NAM"],
        ["name" => "Nauru", "code" => "NR", "phone" => 674, "alpha_3" => "NRU"],
        ["name" => "Nepal", "code" => "NP", "phone" => 977, "alpha_3" => "NPL"],
        ["name" => "Netherlands", "code" => "NL", "phone" => 31, "alpha_3" => "NLD"],
        ["name" => "Netherlands Antilles", "code" => "AN", "phone" => 599, "alpha_3" => "ANT"],
        ["name" => "New Caledonia", "code" => "NC", "phone" => 687, "alpha_3" => "NCL"],
        ["name" => "New Zealand", "code" => "NZ", "phone" => 64, "alpha_3" => "NZL"],
        ["name" => "Nicaragua", "code" => "NI", "phone" => 505, "alpha_3" => "NIC"],
        ["name" => "Niger", "code" => "NE", "phone" => 227, "alpha_3" => "NER"],
        ["name" => "Nigeria", "code" => "NG", "phone" => 234, "alpha_3" => "NGA"],
        ["name" => "Niue", "code" => "NU", "phone" => 683, "alpha_3" => "NIU"],
        ["name" => "Norfolk Island", "code" => "NF", "phone" => 672, "alpha_3" => "NFK"],
        ["name" => "Northern Mariana Islands", "code" => "MP", "phone" => 1670, "alpha_3" => "MNP"],
        ["name" => "Norway", "code" => "NO", "phone" => 47, "alpha_3" => "NOR"],
        ["name" => "Oman", "code" => "OM", "phone" => 968, "alpha_3" => "OMN"],
        ["name" => "Pakistan", "code" => "PK", "phone" => 92, "alpha_3" => "PAK"],
        ["name" => "Palau", "code" => "PW", "phone" => 680, "alpha_3" => "PLW"],
        ["name" => "Palestinian Territory, Occupied", "code" => "PS", "phone" => 970, "alpha_3" => "PSE"],
        ["name" => "Panama", "code" => "PA", "phone" => 507, "alpha_3" => "PAN"],
        ["name" => "Papua New Guinea", "code" => "PG", "phone" => 675, "alpha_3" => "PNG"],
        ["name" => "Paraguay", "code" => "PY", "phone" => 595, "alpha_3" => "PRY"],
        ["name" => "Peru", "code" => "PE", "phone" => 51, "alpha_3" => "PER"],
        ["name" => "Philippines", "code" => "PH", "phone" => 63, "alpha_3" => "PHL"],
        ["name" => "Pitcairn", "code" => "PN", "phone" => 64, "alpha_3" => "PCN"],
        ["name" => "Poland", "code" => "PL", "phone" => 48, "alpha_3" => "POL"],
        ["name" => "Portugal", "code" => "PT", "phone" => 351, "alpha_3" => "PRT"],
        ["name" => "Puerto Rico", "code" => "PR", "phone" => 1787, "alpha_3" => "PRI"],
        ["name" => "Qatar", "code" => "QA", "phone" => 974, "alpha_3" => "QAT"],
        ["name" => "Reunion", "code" => "RE", "phone" => 262, "alpha_3" => "REU"],
        ["name" => "Romania", "code" => "RO", "phone" => 40, "alpha_3" => "ROM"],
        ["name" => "Russian Federation", "code" => "RU", "phone" => 7, "alpha_3" => "RUS"],
        ["name" => "Rwanda", "code" => "RW", "phone" => 250, "alpha_3" => "RWA"],
        ["name" => "Saint Barthelemy", "code" => "BL", "phone" => 590, "alpha_3" => "BLM"],
        ["name" => "Saint Helena", "code" => "SH", "phone" => 290, "alpha_3" => "SHN"],
        ["name" => "Saint Kitts and Nevis", "code" => "KN", "phone" => 1869, "alpha_3" => "KNA"],
        ["name" => "Saint Lucia", "code" => "LC", "phone" => 1758, "alpha_3" => "LCA"],
        ["name" => "Saint Martin", "code" => "MF", "phone" => 590, "alpha_3" => "MAF"],
        ["name" => "Saint Pierre and Miquelon", "code" => "PM", "phone" => 508, "alpha_3" => "SPM"],
        ["name" => "Saint Vincent and the Grenadines", "code" => "VC", "phone" => 1784, "alpha_3" => "VCT"],
        ["name" => "Samoa", "code" => "WS", "phone" => 684, "alpha_3" => "WSM"],
        ["name" => "San Marino", "code" => "SM", "phone" => 378, "alpha_3" => "SMR"],
        ["name" => "Sao Tome and Principe", "code" => "ST", "phone" => 239, "alpha_3" => "STP"],
        ["name" => "Saudi Arabia", "code" => "SA", "phone" => 966, "alpha_3" => "SAU"],
        ["name" => "Senegal", "code" => "SN", "phone" => 221, "alpha_3" => "SEN"],
        ["name" => "Serbia", "code" => "RS", "phone" => 381, "alpha_3" => "SRB"],
        ["name" => "Serbia and Montenegro", "code" => "CS", "phone" => 381, "alpha_3" => "SCG"],
        ["name" => "Seychelles", "code" => "SC", "phone" => 248, "alpha_3" => "SYC"],
        ["name" => "Sierra Leone", "code" => "SL", "phone" => 232, "alpha_3" => "SLE"],
        ["name" => "Singapore", "code" => "SG", "phone" => 65, "alpha_3" => "SGP"],
        ["name" => "St Martin", "code" => "SX", "phone" => 721, "alpha_3" => "SXM"],
        ["name" => "Slovakia", "code" => "SK", "phone" => 421, "alpha_3" => "SVK"],
        ["name" => "Slovenia", "code" => "SI", "phone" => 386, "alpha_3" => "SVN"],
        ["name" => "Solomon Islands", "code" => "SB", "phone" => 677, "alpha_3" => "SLB"],
        ["name" => "Somalia", "code" => "SO", "phone" => 252, "alpha_3" => "SOM"],
        ["name" => "South Africa", "code" => "ZA", "phone" => 27, "alpha_3" => "ZAF"],
        ["name" => "South Georgia and the South Sandwich Islands", "code" => "GS", "phone" => 500, "alpha_3" => "SGS"],
        ["name" => "South Sudan", "code" => "SS", "phone" => 211, "alpha_3" => "SSD"],
        ["name" => "Spain", "code" => "ES", "phone" => 34, "alpha_3" => "ESP"],
        ["name" => "Sri Lanka", "code" => "LK", "phone" => 94, "alpha_3" => "LKA"],
        ["name" => "Sudan", "code" => "SD", "phone" => 249, "alpha_3" => "SDN"],
        ["name" => "Suriname", "code" => "SR", "phone" => 597, "alpha_3" => "SUR"],
        ["name" => "Svalbard and Jan Mayen", "code" => "SJ", "phone" => 47, "alpha_3" => "SJM"],
        ["name" => "Swaziland", "code" => "SZ", "phone" => 268, "alpha_3" => "SWZ"],
        ["name" => "Sweden", "code" => "SE", "phone" => 46, "alpha_3" => "SWE"],
        ["name" => "Switzerland", "code" => "CH", "phone" => 41, "alpha_3" => "CHE"],
        ["name" => "Syrian Arab Republic", "code" => "SY", "phone" => 963, "alpha_3" => "SYR"],
        ["name" => "Taiwan, Province of China", "code" => "TW", "phone" => 886, "alpha_3" => "TWN"],
        ["name" => "Tajikistan", "code" => "TJ", "phone" => 992, "alpha_3" => "TJK"],
        ["name" => "Tanzania, United Republic of", "code" => "TZ", "phone" => 255, "alpha_3" => "TZA"],
        ["name" => "Thailand", "code" => "TH", "phone" => 66, "alpha_3" => "THA"],
        ["name" => "Timor-Leste", "code" => "TL", "phone" => 670, "alpha_3" => "TLS"],
        ["name" => "Togo", "code" => "TG", "phone" => 228, "alpha_3" => "TGO"],
        ["name" => "Tokelau", "code" => "TK", "phone" => 690, "alpha_3" => "TKL"],
        ["name" => "Tonga", "code" => "TO", "phone" => 676, "alpha_3" => "TON"],
        ["name" => "Trinidad and Tobago", "code" => "TT", "phone" => 1868, "alpha_3" => "TTO"],
        ["name" => "Tunisia", "code" => "TN", "phone" => 216, "alpha_3" => "TUN"],
        ["name" => "Turkey", "code" => "TR", "phone" => 90, "alpha_3" => "TUR"],
        ["name" => "Turkmenistan", "code" => "TM", "phone" => 7370, "alpha_3" => "TKM"],
        ["name" => "Turks and Caicos Islands", "code" => "TC", "phone" => 1649, "alpha_3" => "TCA"],
        ["name" => "Tuvalu", "code" => "TV", "phone" => 688, "alpha_3" => "TUV"],
        ["name" => "Uganda", "code" => "UG", "phone" => 256, "alpha_3" => "UGA"],
        ["name" => "Ukraine", "code" => "UA", "phone" => 380, "alpha_3" => "UKR"],
        ["name" => "United Arab Emirates", "code" => "AE", "phone" => 971, "alpha_3" => "ARE"],
        ["name" => "United Kingdom", "code" => "GB", "phone" => 44, "alpha_3" => "GBR"],
        ["name" => "United States", "code" => "US", "phone" => 1, "alpha_3" => "USA"],
        ["name" => "United States Minor Outlying Islands", "code" => "UM", "phone" => 1, "alpha_3" => "UMI"],
        ["name" => "Uruguay", "code" => "UY", "phone" => 598, "alpha_3" => "URY"],
        ["name" => "Uzbekistan", "code" => "UZ", "phone" => 998, "alpha_3" => "UZB"],
        ["name" => "Vanuatu", "code" => "VU", "phone" => 678, "alpha_3" => "VUT"],
        ["name" => "Venezuela", "code" => "VE", "phone" => 58, "alpha_3" => "VEN"],
        ["name" => "Viet Nam", "code" => "VN", "phone" => 84, "alpha_3" => "VNM"],
        ["name" => "Virgin Islands, British", "code" => "VG", "phone" => 1284, "alpha_3" => "VGB"],
        ["name" => "Virgin Islands, U.s.", "code" => "VI", "phone" => 1340, "alpha_3" => "VIR"],
        ["name" => "Wallis and Futuna", "code" => "WF", "phone" => 681, "alpha_3" => "WLF"],
        ["name" => "Western Sahara", "code" => "EH", "phone" => 212, "alpha_3" => "ESH"],
        ["name" => "Yemen", "code" => "YE", "phone" => 967, "alpha_3" => "YEM"],
        ["name" => "Zambia", "code" => "ZM", "phone" => 260, "alpha_3" => "ZMB"],
        ["name" => "Zimbabwe", "code" => "ZW", "phone" => 263, "alpha_3" => "ZWE"]
    ];
}
