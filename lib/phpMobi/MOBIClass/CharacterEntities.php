<?php

/**
 * Description of CharacterEntities
 *
 * @author Sander
 */
class CharacterEntities {
	public static function convert($str){
		//Assume the encoding is UTF-8 -> output is UTF-8
		return $str;
		//return utf8_encode($str);
		//Convert to CP1252
		list($from, $to) = CharacterEntities::generateTables();
		return str_replace($from, $to, $str);
	}

	private static function generateTables(){
		$from = array();
		$to = array();

		for($i = 0; $i < 256; $i++){
			$from[$i] = $to[$i] = chr($i);
		}
		
		$from[0x80] = "€";
		$from[0x82] = "‚";
		$from[0x83] = "ƒ";
		$from[0x84] = "„";
		$from[0x85] = "…";
		$from[0x86] = "†";
		$from[0x87] = "‡";
		$from[0x88] = "ˆ";
		$from[0x89] = "‰";
		$from[0x8A] = "Š";
		$from[0x8B] = "‹";
		$from[0x8C] = "Œ";
		$from[0x8E] = "Ž";

		$from[0x91] = "‘";
		$from[0x92] = "’";
		$from[0x93] = "“";
		$from[0x94] = "”";
		$from[0x95] = "•";
		$from[0x96] = "–";
		$from[0x97] = "—";
		$from[0x98] = "˜";
		$from[0x99] = "™";
		$from[0x9A] = "š";
		$from[0x9B] = "›";
		$from[0x9C] = "œ";
		$from[0x9E] = "ž";
		$from[0x9F] = "Ÿ";

		$from[0xA1] = "¡";
		$from[0xA2] = "¢";
		$from[0xA3] = "£";
		$from[0xA4] = "¤";
		$from[0xA5] = "¥";
		$from[0xA6] = "¦";
		$from[0xA7] = "§";
		$from[0xA8] = "¨";
		$from[0xA9] = "©";
		$from[0xAA] = "ª";
		$from[0xAB] = "«";
		$from[0xAC] = "¬";
		$from[0xAE] = "®";
		$from[0xAF] = "¯";

		$from[0xB0] = "°";
		$from[0xB1] = "±";
		$from[0xB2] = "²";
		$from[0xB3] = "³";
		$from[0xB4] = "´";
		$from[0xB5] = "µ";
		$from[0xB6] = "¶";
		$from[0xB7] = "·";
		$from[0xB8] = "¸";
		$from[0xB9] = "¹";
		$from[0xBA] = "º";
		$from[0xBB] = "»";
		$from[0xBC] = "¼";
		$from[0xBD] = "½";
		$from[0xBE] = "¾";
		$from[0xBF] = "¿";

		$from[0xC0] = "À";
		$from[0xC1] = "Á";
		$from[0xC2] = "Â";
		$from[0xC3] = "Ã";
		$from[0xC4] = "Ä";
		$from[0xC5] = "Å";
		$from[0xC6] = "Æ";
		$from[0xC7] = "Ç";
		$from[0xC8] = "È";
		$from[0xC9] = "É";
		$from[0xCA] = "Ê";
		$from[0xCB] = "Ë";
		$from[0xCC] = "Ì";
		$from[0xCD] = "Í";
		$from[0xCE] = "Î";
		$from[0xCF] = "Ï";

		$from[0xD0] = "Ð";
		$from[0xD1] = "Ñ";
		$from[0xD2] = "Ò";
		$from[0xD3] = "Ó";
		$from[0xD4] = "Ô";
		$from[0xD5] = "Õ";
		$from[0xD6] = "Ö";
		$from[0xD7] = "×";
		$from[0xD8] = "Ø";
		$from[0xD9] = "Ù";
		$from[0xDA] = "Ú";
		$from[0xDB] = "Û";
		$from[0xDC] = "Ü";
		$from[0xDD] = "Ý";
		$from[0xDE] = "Þ";
		$from[0xDF] = "ß";

		$from[0xE0] = "à";
		$from[0xE1] = "á";
		$from[0xE2] = "â";
		$from[0xE3] = "ã";
		$from[0xE4] = "ä";
		$from[0xE5] = "å";
		$from[0xE6] = "æ";
		$from[0xE7] = "ç";
		$from[0xE8] = "è";
		$from[0xE9] = "é";
		$from[0xEA] = "ê";
		$from[0xEB] = "ë";
		$from[0xEC] = "ì";
		$from[0xED] = "í";
		$from[0xEE] = "î";
		$from[0xEF] = "ï";

		$from[0xF0] = "ð";
		$from[0xF1] = "ñ";
		$from[0xF2] = "ò";
		$from[0xF3] = "ó";
		$from[0xF4] = "ô";
		$from[0xF5] = "õ";
		$from[0xF6] = "ö";
		$from[0xF7] = "÷";
		$from[0xF8] = "ø";
		$from[0xF9] = "ù";
		$from[0xFA] = "ú";
		$from[0xFB] = "û";
		$from[0xFC] = "ü";
		$from[0xFD] = "ý";
		$from[0xFE] = "þ";
		$from[0xFF] = "ÿ";
		

		return array($from, $to);
	}
	/*
	00 = U+0000 : NULL
01 = U+0001 : START OF HEADING
02 = U+0002 : START OF TEXT
03 = U+0003 : END OF TEXT
04 = U+0004 : END OF TRANSMISSION
05 = U+0005 : ENQUIRY
06 = U+0006 : ACKNOWLEDGE
07 = U+0007 : BELL
08 = U+0008 : BACKSPACE
09 = U+0009 : HORIZONTAL TABULATION
0A = U+000A : LINE FEED
0B = U+000B : VERTICAL TABULATION
0C = U+000C : FORM FEED
0D = U+000D : CARRIAGE RETURN
0E = U+000E : SHIFT OUT
0F = U+000F : SHIFT IN
10 = U+0010 : DATA LINK ESCAPE
11 = U+0011 : DEVICE CONTROL ONE
12 = U+0012 : DEVICE CONTROL TWO
13 = U+0013 : DEVICE CONTROL THREE
14 = U+0014 : DEVICE CONTROL FOUR
15 = U+0015 : NEGATIVE ACKNOWLEDGE
16 = U+0016 : SYNCHRONOUS IDLE
17 = U+0017 : END OF TRANSMISSION BLOCK
18 = U+0018 : CANCEL
19 = U+0019 : END OF MEDIUM
1A = U+001A : SUBSTITUTE
1B = U+001B : ESCAPE
1C = U+001C : FILE SEPARATOR
1D = U+001D : GROUP SEPARATOR
1E = U+001E : RECORD SEPARATOR
1F = U+001F : UNIT SEPARATOR
20 = U+0020 : SPACE
21 = U+0021 : EXCLAMATION MARK
22 = U+0022 : QUOTATION MARK
23 = U+0023 : NUMBER SIGN
24 = U+0024 : DOLLAR SIGN
25 = U+0025 : PERCENT SIGN
26 = U+0026 : AMPERSAND
27 = U+0027 : APOSTROPHE
28 = U+0028 : LEFT PARENTHESIS
29 = U+0029 : RIGHT PARENTHESIS
2A = U+002A : ASTERISK
2B = U+002B : PLUS SIGN
2C = U+002C : COMMA
2D = U+002D : HYPHEN-MINUS
2E = U+002E : FULL STOP
2F = U+002F : SOLIDUS
30 = U+0030 : DIGIT ZERO
31 = U+0031 : DIGIT ONE
32 = U+0032 : DIGIT TWO
33 = U+0033 : DIGIT THREE
34 = U+0034 : DIGIT FOUR
35 = U+0035 : DIGIT FIVE
36 = U+0036 : DIGIT SIX
37 = U+0037 : DIGIT SEVEN
38 = U+0038 : DIGIT EIGHT
39 = U+0039 : DIGIT NINE
3A = U+003A : COLON
3B = U+003B : SEMICOLON
3C = U+003C : LESS-THAN SIGN
3D = U+003D : EQUALS SIGN
3E = U+003E : GREATER-THAN SIGN
3F = U+003F : QUESTION MARK
40 = U+0040 : COMMERCIAL AT
41 = U+0041 : LATIN CAPITAL LETTER A
42 = U+0042 : LATIN CAPITAL LETTER B
43 = U+0043 : LATIN CAPITAL LETTER C
44 = U+0044 : LATIN CAPITAL LETTER D
45 = U+0045 : LATIN CAPITAL LETTER E
46 = U+0046 : LATIN CAPITAL LETTER F
47 = U+0047 : LATIN CAPITAL LETTER G
48 = U+0048 : LATIN CAPITAL LETTER H
49 = U+0049 : LATIN CAPITAL LETTER I
4A = U+004A : LATIN CAPITAL LETTER J
4B = U+004B : LATIN CAPITAL LETTER K
4C = U+004C : LATIN CAPITAL LETTER L
4D = U+004D : LATIN CAPITAL LETTER M
4E = U+004E : LATIN CAPITAL LETTER N
4F = U+004F : LATIN CAPITAL LETTER O
50 = U+0050 : LATIN CAPITAL LETTER P
51 = U+0051 : LATIN CAPITAL LETTER Q
52 = U+0052 : LATIN CAPITAL LETTER R
53 = U+0053 : LATIN CAPITAL LETTER S
54 = U+0054 : LATIN CAPITAL LETTER T
55 = U+0055 : LATIN CAPITAL LETTER U
56 = U+0056 : LATIN CAPITAL LETTER V
57 = U+0057 : LATIN CAPITAL LETTER W
58 = U+0058 : LATIN CAPITAL LETTER X
59 = U+0059 : LATIN CAPITAL LETTER Y
5A = U+005A : LATIN CAPITAL LETTER Z
5B = U+005B : LEFT SQUARE BRACKET
5C = U+005C : REVERSE SOLIDUS
5D = U+005D : RIGHT SQUARE BRACKET
5E = U+005E : CIRCUMFLEX ACCENT
5F = U+005F : LOW LINE
60 = U+0060 : GRAVE ACCENT
61 = U+0061 : LATIN SMALL LETTER A
62 = U+0062 : LATIN SMALL LETTER B
63 = U+0063 : LATIN SMALL LETTER C
64 = U+0064 : LATIN SMALL LETTER D
65 = U+0065 : LATIN SMALL LETTER E
66 = U+0066 : LATIN SMALL LETTER F
67 = U+0067 : LATIN SMALL LETTER G
68 = U+0068 : LATIN SMALL LETTER H
69 = U+0069 : LATIN SMALL LETTER I
6A = U+006A : LATIN SMALL LETTER J
6B = U+006B : LATIN SMALL LETTER K
6C = U+006C : LATIN SMALL LETTER L
6D = U+006D : LATIN SMALL LETTER M
6E = U+006E : LATIN SMALL LETTER N
6F = U+006F : LATIN SMALL LETTER O
70 = U+0070 : LATIN SMALL LETTER P
71 = U+0071 : LATIN SMALL LETTER Q
72 = U+0072 : LATIN SMALL LETTER R
73 = U+0073 : LATIN SMALL LETTER S
74 = U+0074 : LATIN SMALL LETTER T
75 = U+0075 : LATIN SMALL LETTER U
76 = U+0076 : LATIN SMALL LETTER V
77 = U+0077 : LATIN SMALL LETTER W
78 = U+0078 : LATIN SMALL LETTER X
79 = U+0079 : LATIN SMALL LETTER Y
7A = U+007A : LATIN SMALL LETTER Z
7B = U+007B : LEFT CURLY BRACKET
7C = U+007C : VERTICAL LINE
7D = U+007D : RIGHT CURLY BRACKET
7E = U+007E : TILDE
7F = U+007F : DELETE
80 = U+20AC : EURO SIGN
82 = U+201A : SINGLE LOW-9 QUOTATION MARK
83 = U+0192 : LATIN SMALL LETTER F WITH HOOK
84 = U+201E : DOUBLE LOW-9 QUOTATION MARK
85 = U+2026 : HORIZONTAL ELLIPSIS
86 = U+2020 : DAGGER
87 = U+2021 : DOUBLE DAGGER
88 = U+02C6 : MODIFIER LETTER CIRCUMFLEX ACCENT
89 = U+2030 : PER MILLE SIGN
8A = U+0160 : LATIN CAPITAL LETTER S WITH CARON
8B = U+2039 : SINGLE LEFT-POINTING ANGLE QUOTATION MARK
8C = U+0152 : LATIN CAPITAL LIGATURE OE
8E = U+017D : LATIN CAPITAL LETTER Z WITH CARON
91 = U+2018 : LEFT SINGLE QUOTATION MARK
92 = U+2019 : RIGHT SINGLE QUOTATION MARK
93 = U+201C : LEFT DOUBLE QUOTATION MARK
94 = U+201D : RIGHT DOUBLE QUOTATION MARK
95 = U+2022 : BULLET
96 = U+2013 : EN DASH
97 = U+2014 : EM DASH
98 = U+02DC : SMALL TILDE
99 = U+2122 : TRADE MARK SIGN
9A = U+0161 : LATIN SMALL LETTER S WITH CARON
9B = U+203A : SINGLE RIGHT-POINTING ANGLE QUOTATION MARK
9C = U+0153 : LATIN SMALL LIGATURE OE
9E = U+017E : LATIN SMALL LETTER Z WITH CARON
9F = U+0178 : LATIN CAPITAL LETTER Y WITH DIAERESIS
A0 = U+00A0 : NO-BREAK SPACE
A1 = U+00A1 : INVERTED EXCLAMATION MARK
A2 = U+00A2 : CENT SIGN
A3 = U+00A3 : POUND SIGN
A4 = U+00A4 : CURRENCY SIGN
A5 = U+00A5 : YEN SIGN
A6 = U+00A6 : BROKEN BAR
A7 = U+00A7 : SECTION SIGN
A8 = U+00A8 : DIAERESIS
A9 = U+00A9 : COPYRIGHT SIGN
AA = U+00AA : FEMININE ORDINAL INDICATOR
AB = U+00AB : LEFT-POINTING DOUBLE ANGLE QUOTATION MARK
AC = U+00AC : NOT SIGN
AD = U+00AD : SOFT HYPHEN
AE = U+00AE : REGISTERED SIGN
AF = U+00AF : MACRON
B0 = U+00B0 : DEGREE SIGN
B1 = U+00B1 : PLUS-MINUS SIGN
B2 = U+00B2 : SUPERSCRIPT TWO
B3 = U+00B3 : SUPERSCRIPT THREE
B4 = U+00B4 : ACUTE ACCENT
B5 = U+00B5 : MICRO SIGN
B6 = U+00B6 : PILCROW SIGN
B7 = U+00B7 : MIDDLE DOT
B8 = U+00B8 : CEDILLA
B9 = U+00B9 : SUPERSCRIPT ONE
BA = U+00BA : MASCULINE ORDINAL INDICATOR
BB = U+00BB : RIGHT-POINTING DOUBLE ANGLE QUOTATION MARK
BC = U+00BC : VULGAR FRACTION ONE QUARTER
BD = U+00BD : VULGAR FRACTION ONE HALF
BE = U+00BE : VULGAR FRACTION THREE QUARTERS
BF = U+00BF : INVERTED QUESTION MARK
C0 = U+00C0 : LATIN CAPITAL LETTER A WITH GRAVE
C1 = U+00C1 : LATIN CAPITAL LETTER A WITH ACUTE
C2 = U+00C2 : LATIN CAPITAL LETTER A WITH CIRCUMFLEX
C3 = U+00C3 : LATIN CAPITAL LETTER A WITH TILDE
C4 = U+00C4 : LATIN CAPITAL LETTER A WITH DIAERESIS
C5 = U+00C5 : LATIN CAPITAL LETTER A WITH RING ABOVE
C6 = U+00C6 : LATIN CAPITAL LETTER AE
C7 = U+00C7 : LATIN CAPITAL LETTER C WITH CEDILLA
C8 = U+00C8 : LATIN CAPITAL LETTER E WITH GRAVE
C9 = U+00C9 : LATIN CAPITAL LETTER E WITH ACUTE
CA = U+00CA : LATIN CAPITAL LETTER E WITH CIRCUMFLEX
CB = U+00CB : LATIN CAPITAL LETTER E WITH DIAERESIS
CC = U+00CC : LATIN CAPITAL LETTER I WITH GRAVE
CD = U+00CD : LATIN CAPITAL LETTER I WITH ACUTE
CE = U+00CE : LATIN CAPITAL LETTER I WITH CIRCUMFLEX
CF = U+00CF : LATIN CAPITAL LETTER I WITH DIAERESIS
D0 = U+00D0 : LATIN CAPITAL LETTER ETH
D1 = U+00D1 : LATIN CAPITAL LETTER N WITH TILDE
D2 = U+00D2 : LATIN CAPITAL LETTER O WITH GRAVE
D3 = U+00D3 : LATIN CAPITAL LETTER O WITH ACUTE
D4 = U+00D4 : LATIN CAPITAL LETTER O WITH CIRCUMFLEX
D5 = U+00D5 : LATIN CAPITAL LETTER O WITH TILDE
D6 = U+00D6 : LATIN CAPITAL LETTER O WITH DIAERESIS
D7 = U+00D7 : MULTIPLICATION SIGN
D8 = U+00D8 : LATIN CAPITAL LETTER O WITH STROKE
D9 = U+00D9 : LATIN CAPITAL LETTER U WITH GRAVE
DA = U+00DA : LATIN CAPITAL LETTER U WITH ACUTE
DB = U+00DB : LATIN CAPITAL LETTER U WITH CIRCUMFLEX
DC = U+00DC : LATIN CAPITAL LETTER U WITH DIAERESIS
DD = U+00DD : LATIN CAPITAL LETTER Y WITH ACUTE
DE = U+00DE : LATIN CAPITAL LETTER THORN
DF = U+00DF : LATIN SMALL LETTER SHARP S
E0 = U+00E0 : LATIN SMALL LETTER A WITH GRAVE
E1 = U+00E1 : LATIN SMALL LETTER A WITH ACUTE
E2 = U+00E2 : LATIN SMALL LETTER A WITH CIRCUMFLEX
E3 = U+00E3 : LATIN SMALL LETTER A WITH TILDE
E4 = U+00E4 : LATIN SMALL LETTER A WITH DIAERESIS
E5 = U+00E5 : LATIN SMALL LETTER A WITH RING ABOVE
E6 = U+00E6 : LATIN SMALL LETTER AE
E7 = U+00E7 : LATIN SMALL LETTER C WITH CEDILLA
E8 = U+00E8 : LATIN SMALL LETTER E WITH GRAVE
E9 = U+00E9 : LATIN SMALL LETTER E WITH ACUTE
EA = U+00EA : LATIN SMALL LETTER E WITH CIRCUMFLEX
EB = U+00EB : LATIN SMALL LETTER E WITH DIAERESIS
EC = U+00EC : LATIN SMALL LETTER I WITH GRAVE
ED = U+00ED : LATIN SMALL LETTER I WITH ACUTE
EE = U+00EE : LATIN SMALL LETTER I WITH CIRCUMFLEX
EF = U+00EF : LATIN SMALL LETTER I WITH DIAERESIS
F0 = U+00F0 : LATIN SMALL LETTER ETH
F1 = U+00F1 : LATIN SMALL LETTER N WITH TILDE
F2 = U+00F2 : LATIN SMALL LETTER O WITH GRAVE
F3 = U+00F3 : LATIN SMALL LETTER O WITH ACUTE
F4 = U+00F4 : LATIN SMALL LETTER O WITH CIRCUMFLEX
F5 = U+00F5 : LATIN SMALL LETTER O WITH TILDE
F6 = U+00F6 : LATIN SMALL LETTER O WITH DIAERESIS
F7 = U+00F7 : DIVISION SIGN
F8 = U+00F8 : LATIN SMALL LETTER O WITH STROKE
F9 = U+00F9 : LATIN SMALL LETTER U WITH GRAVE
FA = U+00FA : LATIN SMALL LETTER U WITH ACUTE
FB = U+00FB : LATIN SMALL LETTER U WITH CIRCUMFLEX
FC = U+00FC : LATIN SMALL LETTER U WITH DIAERESIS
FD = U+00FD : LATIN SMALL LETTER Y WITH ACUTE
FE = U+00FE : LATIN SMALL LETTER THORN
FF = U+00FF : LATIN SMALL LETTER Y WITH DIAERESIS
	 * 
	 */
}
?>
