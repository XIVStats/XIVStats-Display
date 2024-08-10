<?php

const COLOR_TANK = "#3d51b1";
const COLOR_HEAL = "#3d6830";
const COLOR_DPS = "#783536";
const COLOR_HAND = "#674ea0";
const COLOR_LAND = "#a88d3b";

const KEY = "KEY";
const TITLE = "TITLE";
const COLOR = "COLOR";
const COUNT = "COUNT";
const TYPE = "TYPE";
const CLASS_GLA = array(KEY => "level_gladiator", TITLE => "Gladiator", COLOR => COLOR_TANK);
const CLASS_PUG = array(KEY => "level_pugilist", TITLE => "Pugilist", COLOR => COLOR_DPS);
const CLASS_MRD = array(KEY => "level_marauder", TITLE => "Marauder", COLOR => COLOR_TANK);
const CLASS_LNC = array(KEY => "level_lancer", TITLE => "Lancer", COLOR => COLOR_DPS);
const CLASS_ARC = array(KEY => "level_archer", TITLE => "Archer", COLOR => COLOR_DPS);
const CLASS_ROG = array(KEY => "level_rogue", TITLE => "Rogue", COLOR => COLOR_DPS);
const CLASS_CNJ = array(KEY => "level_conjurer", TITLE => "Conjurer", COLOR => COLOR_HEAL);
const CLASS_THM = array(KEY => "level_thaumaturge", TITLE => "Thaumaturge", COLOR => COLOR_DPS);
const CLASS_ACN = array(KEY => "level_arcanist", TITLE => "Arcanist", COLOR => COLOR_DPS);
const CLASS_SCH = array(KEY => "level_scholar", TITLE => "Scholar", COLOR => COLOR_HEAL);
const CLASS_DRK = array(KEY => "level_darkknight", TITLE => "Dark Knight", COLOR => COLOR_TANK);
const CLASS_MCH = array(KEY => "level_machinist", TITLE => "Machinist", COLOR => COLOR_DPS);
const CLASS_AST = array(KEY => "level_astrologian", TITLE => "Astrologian", COLOR => COLOR_HEAL);
const CLASS_SAM = array(KEY => "level_samurai", TITLE => "Samurai", COLOR => COLOR_DPS);
const CLASS_RDM = array(KEY => "level_redmage", TITLE => "Red Mage", COLOR => COLOR_DPS);
const CLASS_BLU = array(KEY => "level_bluemage", TITLE => "Blue Mage", COLOR => COLOR_DPS);
const CLASS_GNB = array(KEY => "level_gunbreaker", TITLE => "Gunbreaker", COLOR => COLOR_TANK);
const CLASS_DNC = array(KEY => "level_dancer", TITLE => "Dancer", COLOR => COLOR_DPS);
const CLASS_RPR = array(KEY => "level_reaper", TITLE => "Reaper", COLOR => COLOR_DPS);
const CLASS_SGE = array(KEY => "level_sage", TITLE => "Sage", COLOR => COLOR_HEAL);
const CLASS_CRP = array(KEY => "level_carpenter", TITLE => "Carpenter", COLOR => COLOR_HAND);
const CLASS_BSM = array(KEY => "level_blacksmith", TITLE => "Blacksmith", COLOR => COLOR_HAND);
const CLASS_ARM = array(KEY => "level_armorer", TITLE => "Armorer", COLOR => COLOR_HAND);
const CLASS_GSM = array(KEY => "level_goldsmith", TITLE => "Goldsmith", COLOR => COLOR_HAND);
const CLASS_LWR = array(KEY => "level_leatherworker", TITLE => "Leatherworker", COLOR => COLOR_HAND);
const CLASS_WVR = array(KEY => "level_weaver", TITLE => "Weaver", COLOR => COLOR_HAND);
const CLASS_ALC = array(KEY => "level_alchemist", TITLE => "Alchemist", COLOR => COLOR_HAND);
const CLASS_CUL = array(KEY => "level_culinarian", TITLE => "Culinarian", COLOR => COLOR_HAND);
const CLASS_MIN = array(KEY => "level_miner", TITLE => "Miner", COLOR => COLOR_LAND);
const CLASS_BTN = array(KEY => "level_botanist", TITLE => "Botanist", COLOR => COLOR_LAND);
const CLASS_FSH = array(KEY => "level_fisher", TITLE => "Fisher", COLOR => COLOR_LAND);

// Helper function to fetch the sum of all values in the array, where the array key matches one of the specified realm names
function sumInRegion($data, $regional_realms) {
        return array_sum(array_intersect_key($data, array_flip($regional_realms)));
}

// Helper function that returns zero if the value supplied isn't set
function getValue($value) {
    return isset($value) ? $value : 0;
}

// Helper function to return the value of the requested key, or zero if one isn't available
function getValueFromArray($data, $key) {
    return !array_key_exists($key, $data) ? 0 : getValue($data[$key]);
}

// Helper function to increment class count into the supplied total array
function handleClass($row, $classDef, &$totalArray) {
    if(!isset($totalArray[$classDef[KEY]])) {
        $totalArray[$classDef[KEY]] = array();
        $totalArray[$classDef[KEY]][COUNT] = 0;
        $totalArray[$classDef[KEY]][TYPE] = $classDef;
    }
    $level = isset($row[$classDef[KEY]]) ? $row[$classDef[KEY]] : 0;
    if($level > 0) {
        $totalArray[$classDef[KEY]][COUNT]++;
    }
    return 0;
}

$conn_info = parse_ini_file("templateconfig.ini");

$date = date("F Y");

// Create DB Connection
$db = new mysqli($conn_info["host"], $conn_info["username"], $conn_info["password"]);

// Check DB Connection
if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
}

// Select DB
if (! $db->select_db($conn_info["database"])) {
        die("Couldn't find DB");
}

// Servers by region
$american_realm_array = array("Behemoth","Brynhildr","Diabolos","Exodus","Famfrit","Hyperion",
                              "Lamia","Leviathan","Malboro","Ultros","Adamantoise","Balmung",
                              "Cactuar","Coeurl","Faerie","Gilgamesh","Goblin","Jenova","Mateus",
                              "Midgardsormr","Sargatanas","Siren","Zalera","Excalibur",
                              "Halicarnassus", "Maduin", "Marilith", "Seraph", "Cuchulainn", "Golem", "Kraken", "Rafflesia");
sort($american_realm_array);

$japanese_realm_array = array("Alexander","Bahamut","Durandal","Fenrir","Ifrit","Ridill","Tiamat","Ultima",
                              "Valefor","Yojimbo","Zeromus","Anima","Asura","Belias","Chocobo","Hades",
                              "Ixion","Mandragora","Masamune","Pandaemonium","Shinryu","Titan","Aegis",
                              "Atomos","Carbuncle","Garuda","Gungnir","Kujata","Ramuh","Tonberry","Typhon","Unicorn");
sort($japanese_realm_array);

$european_realm_array = array("Cerberus","Lich","Moogle","Odin","Phoenix","Ragnarok","Shiva","Zodiark","Louisoix","Omega",
                              "Spriggan","Twintania", "Sagittarius", "Phantom", "Alpha", "Raiden");
sort($european_realm_array);

$oceanian_realm_array = array("Bismarck", "Ravana", "Sephirot", "Sophia", "Zurvan");
sort($oceanian_realm_array);

// Variables
$player_count = 0;
$active_player_count = 0;
$deleted_player_count = 0;
$realm_count = array();
$active_realm_count = array();
$gc_count = array();
$active_gc_count = array();
$race_gender_count = array();
$active_race_gender_count = array();

$classes = array();

$active_classes = array();

// VARIABLES

// Pre-Orders
$prearr = 0;
$prehw = 0;
$presb = 0;
$preshb = 0;
$preew = 0;
$predt = 0;

// Collectors Editions
$arr_collectors = 0;
$hw_collectors = 0;
$sb_collectors = 0;
$shb_collectors = 0;
$ew_collectors = 0;
$dt_collectors = 0;

// Artbook
$arrartbook = 0;
$hw_artbook = 0;
$hw_artbooktwo = 0;
$sbartbooktwo = 0;
$sbartbook = 0;
$shb_artbook = 0;
$shb_artbooktwo = 0;
$ew_artbook = 0;
$ew_artbooktwo = 0;

// Encyclopaedia Eorzea
$encyclopaediaeorzea_one = 0;
$encyclopaediaeorzea_three = 0;

// Plushes
$moogleplush = 0;
$topazcarbuncle_plush = 0;
$emeraldcarbuncle_plush = 0;

// Soundtracks
$beforemeteor = 0;
$arr_soundtrack = 0;
$beforethefall = 0;
$hw_soundtrack = 0;
$faredgeoffate = 0;
$sb_soundtrack = 0;
$shb_soundtrack = 0;
$deathuntodawn = 0;
$ew_soundtrack = 0;
$growinglight = 0;

// Eternal Bond
$saw_eternal_bond = 0;
$did_eternal_bond = 0;

// Sightseeing 
$sightseeing = 0;

// Hildibrand Questline
$arr_hildibrand = 0;
$hw_hildibrand = 0;
$ew_hildibrand = 0;

// Commendations
$comm50 = 0;
$comm500 = 0;
$comm3000 = 0;

$beast_tribes = array();
// A Realm Reborn
$beast_tribes["Kobold"] = 0;
$beast_tribes["Sahagin"] = 0;
$beast_tribes["Amaljaa"] = 0;
$beast_tribes["Sylph"] = 0;
$beast_tribes["Ixal"] = 0;
// Heavensward
$beast_tribes["Vanu Vanu"] = 0;
$beast_tribes["Vath"] = 0;
$beast_tribes["Moogle"] = 0;
// Stormblood
$beast_tribes["Kojin"] = 0;
$beast_tribes["Ananta"] = 0;
$beast_tribes["Namazu"] = 0;
// Shadowbringers
$beast_tribes["Pixie"] = 0;
$beast_tribes["Qitari"] = 0;
$beast_tribes["Dwarf"] = 0;
// Endwalker
$beast_tribes["Arkasodara"] = 0;
$beast_tribes["Omnicron"] = 0;
$beast_tribes["Loporrit"] = 0;

// Other mounts
$literal_whale = 0;

// PvP
$pvp_200_wins = 0;
$pvp_s2l1516_reward = 0;
$pvp_s2l25_reward = 0;
$pvp_s3l15_reward = 0;
$pvp_s4l15_reward = 0;
$pvp_s4l25_reward = 0;
$pvp_s5l15_reward = 0;

// Anniversary Events
$ninth_anniversary = 0;

// Anniversary Events
$ninth_anniversary = 0;

// Variant & Criterion Dungeons
$all_survey_sildihn = 0;
$all_survey_rokkon = 0;
$all_survey_aloalo = 0;

// Deep Dungeon
$vintage_vogue_achievement = 0;

$player_overview_query = $db->query("SELECT * FROM tblplayers;", MYSQLI_USE_RESULT);
while($row = $player_overview_query->fetch_assoc()) {
    // Skip deleted characters
    if(isset($row["character_status"]) && $row["character_status"] == "DELETED") {
        $deleted_player_count++;
        continue;
    }

    // Expand the mounts & minions to an array
    $mounts = isset($row["mounts"]) ? str_getcsv($row["mounts"]) : array();
    $minions = isset($row["minions"]) ? str_getcsv($row["minions"]) : array();

    // Basic data
    $realm = isset($row["realm"]) ? $row["realm"] : 'Unknown';
    $grand_company = isset($row["grand_company"]) ? $row["grand_company"] : 'Unknown';
    $race = isset($row["race"]) ? $row["race"] : 'Unknown';
    $gender = isset($row["gender"]) ? $row["gender"] : 'Unknown';
    
    // Fetch total number of players in database
    $player_count++;
    // Fetch realm player counts
    if(!array_key_exists($realm, $realm_count)) {
            $realm_count[$realm] = 0;
    }
    $realm_count[$realm]++;
    // Fetch grand company player count
    if(!array_key_exists($grand_company, $gc_count)) {
            $gc_count[$grand_company] = 0;
    }
    $gc_count[$grand_company]++;
    // Fetch race and gender player count
    if(!array_key_exists($race, $race_gender_count)) {
            $race_gender_count[$race] = array();
    }
    if(!array_key_exists($gender, $race_gender_count[$race])) {
            $race_gender_count[$race][$gender] = 0;
    }
    $race_gender_count[$race][$gender]++;

    // Tanks
    handleClass($row, CLASS_GLA, $classes);
    handleClass($row, CLASS_MRD, $classes);
    handleClass($row, CLASS_DRK, $classes);
    handleClass($row, CLASS_GNB, $classes);

    // Healers
    handleClass($row, CLASS_CNJ, $classes);
    handleClass($row, CLASS_SCH, $classes);
    handleClass($row, CLASS_AST, $classes);
    handleClass($row, CLASS_SGE, $classes);

    // Melee DPS
    handleClass($row, CLASS_PUG, $classes);
    handleClass($row, CLASS_LNC, $classes);
    handleClass($row, CLASS_ROG, $classes);
    handleClass($row, CLASS_SAM, $classes);
    handleClass($row, CLASS_RPR, $classes);

    // Physical Ranged DPS
    handleClass($row, CLASS_ARC, $classes);
    handleClass($row, CLASS_MCH, $classes);
    handleClass($row, CLASS_DNC, $classes);

    // Magical Ranged DPS
    handleClass($row, CLASS_THM, $classes);
    handleClass($row, CLASS_ACN, $classes);
    handleClass($row, CLASS_RDM, $classes);
    handleClass($row, CLASS_BLU, $classes);

    // Disciples of Hand
    handleClass($row, CLASS_CRP, $classes);
    handleClass($row, CLASS_BSM, $classes);
    handleClass($row, CLASS_ARM, $classes);
    handleClass($row, CLASS_GSM, $classes);
    handleClass($row, CLASS_LWR, $classes);
    handleClass($row, CLASS_WVR, $classes);
    handleClass($row, CLASS_ALC, $classes);
    handleClass($row, CLASS_CUL, $classes);

    // Disciples of Land
    handleClass($row, CLASS_MIN, $classes);
    handleClass($row, CLASS_BTN, $classes);
    handleClass($row, CLASS_FSH, $classes);

    // Pre-orders
    $prearr += in_array("Cait Sith Doll", $minions) ? 1 : 0;
    $fmt_prearr = number_format($prearr);
    $prehw += in_array("Chocobo Chick Courier", $minions) ? 1 : 0;
    $fmt_prehw = number_format($prehw);
    $presb += in_array("Wind-up Red Mage", $minions) ? 1 : 0;
    $fmt_presb = number_format($presb);
    $preshb += in_array("Baby Gremlin", $minions) ? 1 : 0;
    $fmt_preshb = number_format($preshb);
    $preew += in_array("Wind-up Palom", $minions) ? 1 : 0;
    $fmt_preew = number_format($preew);
    $predt += in_array("Wind-up Zidane", $minions) ? 1 : 0;
    $fmt_predt = number_format($predt);

    // Collectors Edition
    $arr_collectors += in_array("Fat Chocobo", $mounts) || in_array("Coeurl", $mounts) || in_array("Wind-Up Moogle", $minions) || in_array("Baby Behemoth", $minions) ? 1 : 0;
    $fmt_arr_collectors = number_format($arr_collectors);
    $hw_collectors += in_array("Wind-up Kain", $minions) || in_array("Griffin", $mounts)? 1 : 0;
    $fmt_hw_collectors = number_format($hw_collectors);
    $sb_collectors += in_array("Syldra", $mounts) || in_array("Wind-up Bartz", $minions)? 1 : 0;
    $fmt_sb_collectors = number_format($sb_collectors);
    $shb_collectors += in_array("Grani", $mounts) ? 1 : 0;
    $fmt_shb_collectors = number_format($shb_collectors);
    $ew_collectors += in_array("Arion", $mounts) ? 1 : 0;
    $fmt_ew_collectors = number_format($ew_collectors);
    $dt_collectors += in_array("Ark", $mounts) ? 1 : 0;
    $fmt_dt_collectors = number_format($dt_collectors);

    // Physical Items
    // Soundtracks
    $beforemeteor += in_array("Wind-up Dalamud", $minions) ? 1 : 0;
    $fmt_beforemeteor = number_format($beforemeteor);
    $arr_soundtrack += in_array("Wind-up Bahamut", $minions) ? 1 : 0;
    $fmt_arr_soundtrack = number_format($arr_soundtrack);
    $beforethefall += in_array("Set Of Primogs", $minions) ? 1 : 0;
    $fmt_beforethefall = number_format($beforethefall);
    $hw_soundtrack += in_array("Spoony Bard", $minions) ? 1 : 0;
    $fmt_hw_soundtrack = number_format($hw_soundtrack);
    $faredgeoffate += in_array("Wind-up Nidhogg", $minions) ? 1 : 0;
    $fmt_faredgeoffate = number_format($faredgeoffate);
    $sb_soundtrack += in_array("Wind-up Tsukuyomi", $minions) ? 1 : 0;
    $fmt_sb_soundtrack = number_format($sb_soundtrack);
    $shb_soundtrack += in_array("Wind-up Suzaku", $minions) ? 1 : 0;
    $fmt_shb_soundtrack = number_format($shb_soundtrack);
    $deathuntodawn += in_array("Wind-up Lyna", $minions) ? 1 : 0;
    $fmt_deathuntodawn = number_format($deathuntodawn);
    $ew_soundtrack += in_array("Wind-up Vrtra", $minions) ? 1 : 0;
    $fmt_ew_soundtrack = number_format($ew_soundtrack);
    $growinglight += in_array("Hydaelyn Idol", $minions) ? 1 : 0;
    $fmt_growinglight = number_format($growinglight);

    // Art Books
    $arrartbook += in_array("Model Enterprise", $minions) ? 1 : 0;
    $fmt_arrartbook = number_format($arrartbook);
    $hw_artbook += in_array("Wind-up Relm", $minions) ? 1 : 0;
    $fmt_hw_artbook = number_format($hw_artbook);
    $hw_artbooktwo += in_array("Wind-up Hraesvelgr", $minions) ? 1 : 0;
    $fmt_hw_artbooktwo = number_format($hw_artbooktwo);
    $sbartbook += in_array("Dress-up Tataru", $minions) ? 1 : 0;
    $fmt_sbartbook = number_format($sbartbook);
    $sbartbooktwo += in_array("Wind-up Yotsuyu", $minions) ? 1 : 0;
    $fmt_sbartbooktwo = number_format($sbartbooktwo);
    $shb_artbook += in_array("Wind-up Runar", $minions) ? 1 : 0;
    $fmt_shb_artbook = number_format($shb_artbook);
    $shb_artbooktwo += in_array("Wind-up Dulia-Chai", $minions) ? 1 : 0;
    $fmt_shb_artbooktwo = number_format($shb_artbooktwo);
    $ew_artbook += in_array("Wind-up Ragnarok", $minions) ? 1 : 0;
    $fmt_ew_artbook = number_format($ew_artbook);
    $ew_artbooktwo += in_array("Zodiark Idol", $minions) ? 1 : 0;
    $fmt_ew_artbooktwo = number_format($ew_artbooktwo);

    // Encyclopaedia Eorzea 
    $encyclopaediaeorzea_one += in_array("Namingway", $minions) ? 1 : 0;
    $fmt_encyclopaediaeorzea_one = number_format($encyclopaediaeorzea_one);
    $encyclopaediaeorzea_three += in_array ("Wind-up Fourchenault", $minions) ? 1 : 0;
    $fmt_encyclopaediaeorzea_three = number_format($encyclopaediaeorzea_three);

    // Plushes & Other Items
    $moogleplush += in_array("Wind-up Delivery Moogle", $minions) ? 1 : 0;
    $fmt_moogleplush = number_format($moogleplush);
    $topazcarbuncle_plush += in_array("Heliodor Carbuncle", $minions) ? 1 : 0;
    $fmt_topazcarbuncle_plush = number_format($topazcarbuncle_plush);
    $emeraldcarbuncle_plush += in_array("Peridot Carbuncle", $minions) ? 1 : 0;
    $fmt_emeraldcarbuncle_plush = number_format($emeraldcarbuncle_plush);


    // Eternal Bond
    $saw_eternal_bond += in_array("Demon Box", $minions) ? 1 : 0;
    $fmt_saw_eternal_bond = number_format($saw_eternal_bond);
    $did_eternal_bond += in_array("Ceremony Chocobo", $mounts) ? 1 : 0;
    $fmt_did_eternal_bond = number_format($did_eternal_bond);

    // Player Commendations
    $comm50 += in_array("Princely Hatchling", $minions) ? 1 : 0;
    $fmt_comm50 = number_format($comm50);
    $comm500 += in_array("Gilded Magitek Armor", $mounts) ? 1 : 0;
    $fmt_comm500 = number_format($comm500);
    $comm3000 += in_array("Parade Chocobo", $mounts) ? 1 : 0;
    $fmt_comm3000 = number_format($comm3000);

    // Hildibrand
    $arr_hildibrand += in_array("Wind-up Gentleman", $minions) ? 1 : 0;
    $fmt_arr_hildibrand = number_format($arr_hildibrand);
    $hw_hildibrand += in_array("Gigi", $minions) ? 1 : 0;
    $fmt_hw_hildibrand = number_format($hw_hildibrand);
    $ew_hildibrand += in_array("UFO", $mounts) ? 1 : 0;
    $fmt_ew_hildibrand = number_format($ew_hildibrand);

    // ARR Sightseeing Log
    $sightseeing += in_array("Fledgling Apkallu", $minions) ? 1 : 0;
    $fmt_sightseeing = number_format($sightseeing);

	// Deleted count
	$fmt_deleted = number_format($deleted_player_count);

    // Beast Tribes - Any mount or minions that can be obtained from a high beast tribe or purchasing with Gil (after reaching a high rank) 
    // A Realm Reborn
    $beast_tribes["Kobold"] += in_array("Wind-up Kobold", $minions) || in_array("Wind-up Kobolder", $minions) || in_array("Bomb Palanquin", $mounts) ? 1 : 0;
    $beast_tribes["Sahagin"] += in_array("Cavalry Elbst", $mounts) || in_array("Wind-up Sahagin", $minions) ? 1 : 0;
    $beast_tribes["Amaljaa"] += in_array("Wind-up Amalj'aa", $minions) || in_array("Cavalry Drake Mount", $mounts) ? 1 : 0;
    $beast_tribes["Sylph"] += in_array("Wind-up Sylph", $minions) || in_array("Laurel Goobbue", $mounts) ? 1 : 0;
    $beast_tribes["Ixal"] += in_array("Wind-up Ixal", $minions) ? 1 : 0;

    // Heavensward
    $beast_tribes["Vanu Vanu"] += in_array("Sanuwa", $mounts) || in_array("Wind-up Zundu Warrior", $minions) || in_array("Wind-up Gundu Warrior", $minions) ? 1 : 0;
    $beast_tribes["Vath"] += in_array("Wind-up Gnath", $minions) || in_array("Wind-up Vath", $minions) || in_array("Kongamato", $mounts) ? 1 : 0;
    $beast_tribes["Moogle"] += in_array("Cloud Mallow", $mounts) || in_array("Wind-up Dragonet", $minions) || in_array("Wind-up Ohl Deeh", $minions) ? 1 : 0;
    
    // Stormblood
	$beast_tribes["Kojin"] += in_array("Striped Ray", $mounts) || in_array("Wind-up Kojin", $minions) || in_array("Zephyrous Zabuton", $minions) || in_array("Wind-up Redback", $minions) ? 1 : 0;
	$beast_tribes["Ananta"] += in_array("Wind-up Ananta", $minions) || in_array("Wind-up Qalyana", $minions) || in_array("True Griffin", $mounts) || in_array("Marid", $mounts) ? 1 : 0;        
	$beast_tribes["Namazu"] += in_array("Attendee #777", $minions) || in_array("Mikoshi", $mounts) ? 1 : 0;
    
    // Shadowbringers
    $beast_tribes["Pixie"] += in_array("Wind-up Pixie", $minions) || in_array("Portly Porxie", $mounts) ? 1 : 0;
    $beast_tribes["Qitari"] += in_array("Great Vessel Of Ronka", $mounts) || in_array("The Behelmeted Serpent Of Ronka", $minions) || in_array("The Behatted Serpent Of Ronka", $minions) ? 1 : 0;
    $beast_tribes["Dwarf"] += in_array("Lalinator 5.H0", $minions) || in_array("Rolling Tankard", $mounts) ? 1 : 0;

    // Endwalker
    $beast_tribes["Arkasodara"] += in_array("Wind-up Arkasodara", $minions) || in_array("Hippo Cart", $mounts) ? 1 : 0;
    $beast_tribes["Omnicron"] += in_array("Lumini", $minions) || in_array("Miw Miisv", $mounts) ? 1 : 0;
    $beast_tribes["Loporrit"] += in_array("Findingway", $minions) || in_array("Moon-hopper", $mounts) ? 1 : 0;
  
    // Other mounts
    $literal_whale += in_array("Lunar Whale", $mounts) ? 1 : 0;
    $fmt_literal_whale = number_format($literal_whale);
    $literal_whale_in_usd = number_format($literal_whale*42);

    // PvP
        // PvP 200 Wins
        $pvp_200_wins += in_array("Gloria-class Airship", $mounts) ? 1 : 0;
        $fmt_pvp_200_wins = number_format($pvp_200_wins);
    
        // Crystalline Conflict
            // Series 2 - Level 15 & 16 Rewards
            $pvp_s2l1516_reward += in_array("Clockwork Cerulean Chaser", $minions) || in_array("Clockwork Crimson Chaser", $minions) ? 1 : 0;
            $fmt_pvp_s2l1516_reward = number_format($pvp_s2l1516_reward);
            // Series 2 - Level 25 Reward
            $pvp_s2l25_reward += in_array("Fylgja", $mounts) ? 1 : 0;
            $fmt_pvp_s2l25_reward = number_format($pvp_s2l25_reward);
            // Series 3 - Level 15 Reward
            $pvp_s3l15_reward += in_array("Logistics Node", $mounts) ? 1 : 0;
            $fmt_pvp_s3l15_reward = number_format($pvp_s3l15_reward);
            // Series 4 - Level 15 Reward
            $pvp_s4l15_reward += in_array("Rubellite Weapon", $minions) ? 1 : 0;
            $fmt_pvp_s4l15_reward = number_format($pvp_s4l15_reward);
            // Series 4 - Level 25 Reward
            $pvp_s4l25_reward += in_array("Traveling Supporter", $mounts) ? 1 : 0;
            $fmt_pvp_s4l25_reward = number_format($pvp_s4l25_reward);
            // Series 5 - Level 15 Reward
            $pvp_s5l15_reward += in_array("Tourmaline Weapon", $minions) ? 1 : 0;
            $fmt_pvp_s5l15_reward = number_format($pvp_s5l15_reward);

    // Anniversary Events
    $ninth_anniversary += in_array("Clockwork Solus", $minions) ? 1 : 0;
    $fmt_ninth_anniversary = number_format($ninth_anniversary);

    // Anniversary Events
    $ninth_anniversary += in_array("Clockwork Solus", $minions) ? 1 : 0;
    $fmt_ninth_anniversary = number_format($ninth_anniversary);

    // Variant & Criterion Dungeons
    $all_survey_sildihn += in_array("Silkie", $mounts) ? 1 : 0;
    $fmt_all_survey_sildihn = number_format($all_survey_sildihn);
    $all_survey_rokkon += in_array("Burabura Chochin", $mounts) ? 1 : 0;
    $fmt_all_survey_rokkon = number_format($all_survey_rokkon);
    $all_survey_aloalo += in_array("Spectral Statice", $mounts) ? 1 : 0;
    $fmt_all_survey_aloalo = number_format($all_survey_aloalo);

    // Deep Dungeon
    $vintage_vogue_achievement += in_array("Aeturna", $mounts) ? 1 : 0;
    $fmt_vintage_vogue_achievement = number_format($vintage_vogue_achievement);

    // Fetch total number of active players in database by checking for the 'Wind-up Herois' minion received during 6.0 MSQ
    // Can also check for 'Argos' mount (Item: Argos Horn) as it was given during 6.0 MSQ from the same quest.
    if(in_array("Wind-up Herois", $minions) || in_array("Argos", $mounts)) {  $active_player_count++;
        // Fetch realm active player count
        if(!array_key_exists($realm, $active_realm_count)) {
                $active_realm_count[$realm] = 0;
        }
        $active_realm_count[$realm]++;
        // Fetch granc company active player count
        if(!array_key_exists($grand_company, $active_gc_count)) {
                $active_gc_count[$grand_company] = 0;
        }
        $active_gc_count[$grand_company]++;
        // Fetch race and gender active player count
        if(!array_key_exists($race, $active_race_gender_count)) {
                $active_race_gender_count[$race] = array();
        }
        if(!array_key_exists($gender, $active_race_gender_count[$race])) {
                $active_race_gender_count[$race][$gender] = 0;
        }
        $active_race_gender_count[$race][$gender]++;

        // Tanks
        handleClass($row, CLASS_GLA, $active_classes);
        handleClass($row, CLASS_MRD, $active_classes);
        handleClass($row, CLASS_DRK, $active_classes);
        handleClass($row, CLASS_GNB, $active_classes);

        // Healers
        handleClass($row, CLASS_CNJ, $active_classes);
        handleClass($row, CLASS_SCH, $active_classes);
        handleClass($row, CLASS_AST, $active_classes);
        handleClass($row, CLASS_SGE, $active_classes);

        // Melee DPS
        handleClass($row, CLASS_PUG, $active_classes);
        handleClass($row, CLASS_LNC, $active_classes);
        handleClass($row, CLASS_ROG, $active_classes);
        handleClass($row, CLASS_SAM, $active_classes);
        handleClass($row, CLASS_RPR, $active_classes);

        // Physical Ranged DPS
        handleClass($row, CLASS_ARC, $active_classes);
        handleClass($row, CLASS_MCH, $active_classes);
        handleClass($row, CLASS_DNC, $active_classes);

        // Magical Ranged DPS
        handleClass($row, CLASS_THM, $active_classes);
        handleClass($row, CLASS_ACN, $active_classes);
        handleClass($row, CLASS_RDM, $active_classes);
        handleClass($row, CLASS_BLU, $active_classes);

        // Disciples of Hand
        handleClass($row, CLASS_CRP, $active_classes);
        handleClass($row, CLASS_BSM, $active_classes);
        handleClass($row, CLASS_ARM, $active_classes);
        handleClass($row, CLASS_GSM, $active_classes);
        handleClass($row, CLASS_LWR, $active_classes);
        handleClass($row, CLASS_WVR, $active_classes);
        handleClass($row, CLASS_ALC, $active_classes);
        handleClass($row, CLASS_CUL, $active_classes);

        // Disciples of Land
        handleClass($row, CLASS_MIN, $active_classes);
        handleClass($row, CLASS_BTN, $active_classes);
        handleClass($row, CLASS_FSH, $active_classes);
    }
}

ksort($gc_count);
ksort($active_gc_count);
ksort($race_gender_count);
ksort($active_race_gender_count);

// Close DB Connection
$db->close();

?>
<html>

<head>
    <title>XIVCensus - Character statistics for FFXIV</title>
    <!-- FFXIV Official Tooltips-->
    <script src="https://img.finalfantasyxiv.com/lds/pc/global/js/eorzeadb/loader.js?v3"></script>
    <!-- JQuery Script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Highcharts-->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!-- Fork Awesome-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
    $(document).ready(function(){
    $('.modal').modal();
    $('.dropdown-trigger').dropdown();
    });
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WXM41K6BMN"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-WXM41K6BMN');
    </script>
    <style>
        /*
            Core colour palette (https://coolors.co/303440-c3ac5c-44aadf-702670-9e0000-039be5):
                - #212121 - Grey Darken-4 - Background
                - #303440 - Gunmetel - Card background
                - #c3ac5c - Vega Gold - Titles and highlights
                - #44aadf - Royal Blue - Main theme color (Blue, Endwalker)
                - #702670 - Midnight - Secondary theme colour (Purple, Shadowbringers)
                - #9E0000 - USC Cardinal - Secondary theme color (Crimson, Stormblood)
                - #039BE5 - Vivid Ceruleum - Secondary theme color (Azure, Heavensward)

            Role colour palette:
                - #3d51b1 - Tank
                - #3d6830 - Healer
                - #783536 - DPS
                - #674ea0 - DoH
                - #a88d3b - DoL
          */

        /* .row {
            display: block;
        } */

        a {
            color: white;
            /* text-decoration-line: dotted; */
        }

        .logo {
            display: block;
            position: relative;
        }

        .card-header {
            background-image: url(img/logo_ew.png);
            background-repeat: no-repeat;
            margin-bottom: 10px;
            height: 220px;
        }

        .card {
            background-color: #303440;
        }

        .card-title {
            color: #c3ac5c;
        }

        .card-content {
            color: white;
        }

        p a:hover {
            color: #44aadf;
        }

        hr {
            color: #c3ac5c;
            background-color: #c3ac5c;
            height: 3px;
            border: 0;
        }

        .box-element {
            width: 100%;
        }

        #pageTitleBox {
            margin-top: 30px;
            margin-bottom: 0;
        }

        .region-title {
            text-align: center;
            color: #c3ac5c;
            font-size: 28pt;
        }

        .region-subtitle {
            text-align: center;
            color: white;
            font-size: large;
        }

        .region-medsubtitle {
            text-align: center;
            color: white;
            font-size: medium;
        }

        .region-stat {
            text-align: center;
            font-size: 48pt;
        }

        .region-stat-diff {
            font-size: medium;
        }

        .region-stat-label {
            text-align: center;
            font-size: large;
        }

        .dropdown-button,
        .waves-light,
        .btn,
        .btn-large,
        .btn:visited {
            background: linear-gradient(to right, #3d4d99 0%, #3689b3 50%, #cc7a29 100%);
        }

        .dropdown-button:hover,
        .waves-light:hover,
        .btn:hover,
        .btn-large:hover{
            background: linear-gradient(to right, #4c5fbf 0%, #44aadf 50%, #ff9933 100%);
        }

        #realm-dropdown a,
        #pop-dropdown a,
        #misc-stats-dropdown a {
            color: black;
        }

        #realm-dropdown a:hover,
        #pop-dropdown a:hover,
        #misc-stats-dropdown a:hover {
            background: linear-gradient(to right, #4c5fbf 0%, #44aadf 50%, #ff9933 100%);
            color: #ffffff;
        }

        .navbar{
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            color: white;
        }

        .main-nav-scrolled {
            z-index: 1;
            position: fixed;
            width: 100%;
            top: 0;
        }

        footer.page-footer {
            margin-top: 0px;
            padding-top: 0px;
            background-color: #c3ac5c;
        }
    </style>
</head>

<body class="grey darken-4">
    <div class="container box-element">
        <div class="row" id="pageTitleBox">
            <div class="card-header">
                <div class="card-content" style="padding-top: 100px">
                    <p style="margin-left: 24px;">Statistics for
                        <?php echo $date; ?>
                    </p>
                    <p style="margin-left: 24px;"><b>Any reference to "Endgame" characters, refers to characters that
                            have claimed the following item: <br />
                            The minion &amp; mount for completing the Endwalker Main Scenario Quest from the Patch
                            6.0 story</b></p>
                    <!-- Un/comment next 3 lines to enable site notice (For bugs/outages, etc)-->
                    <!-- <div class="col s12 m6" style="width:100%;">
                    <div class="card light region-title"><h4 style="color: red;">ALERT: We are currently aware of a bug which is falsely reporting characters as deleted and thus missing from the census. We are working to fix this bug.</h4></div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col s12 m6 navbar center">
            <!-- Navbar - 'Population', 'Realm Stats' & 'Other Stats' are dropdowns-->
            <a class='dropdown-trigger btn' href='#' data-target='pop-dropdown'>Population</a>
            <a class="waves-effect waves-light btn" href='#racegender'>Race &amp; Gender Stats</a>
            <a class="waves-effect waves-light btn" href='#class'>Class Stats</a>
            <a class='dropdown-trigger btn' href='#' data-target='realm-dropdown'>Realm Stats</a>
            <a class="waves-effect waves-light btn" href='#grandcompany'>Grand Company Stats</a>
            <a class='dropdown-trigger btn' href='#' data-target='misc-stats-dropdown'>Other Stats</a>
            <a class="waves-effect waves-light btn" href='#top'><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
            Follow us: 
            <a href="https://etheirys.masto.host/@ffxivcensus"><i class="fa fa-mastodon" aria-hidden="true"></i></a>
            <a href="https://twitter.com/ffxivcensus"><i class="fa fa-twitter" aria-hidden="true"></i></a>

            <!-- Population Stats Dropdown -->
            <ul id='pop-dropdown' class='dropdown-content'>
                <li><a href="#population">World</a></li>
                <li class="divider" tabindex="-1"></li>
                <li><a href="#popna">North America</a></li>
                <li><a href="#popjp">Japan</a></li>
                <li><a href="#popeu">Europe</a></li>
                <li><a href="#popoc">Oceania</a></li>
            </ul>

            <!-- Realm Stats Dropdown -->
            <ul id='realm-dropdown' class='dropdown-content'>
                <li><a href="#realmall">Realm Stats (All-Time)</a></li>
                <li class="divider" tabindex="-1"></li>
                <li><a href="#rat-na">North America</a></li>
                <li><a href="#rat-jp">Japan</a></li>
                <li><a href="#rat-eu">Europe</a></li>
                <li><a href="#rat-oc">Oceania</a></li>
                <li class="divider" tabindex="-1"></li>
                <li class="divider" tabindex="-1"></li>
                <li><a href="#realmendgame">Realm Stats (Endgame)</a></li>
                <li class="divider" tabindex="-1"></li>
                <li><a href="#ra-na">North America</a></li>
                <li><a href="#ra-jp">Japan</a></li>
                <li><a href="#ra-eu">Europe</a></li>
                <li><a href="#ra-oc">Oceania</a></li>
            </ul>

            <!-- Other Stats Dropdown -->
            <ul id='misc-stats-dropdown' class='dropdown-content'>
                <li><a href="#tribal">Tribal Quests</a></li>
                <li><a href="#preorders">Pre-Orders</a></li>
                <li><a href="#collectors">Collectors Edition</a></li>
                <li class="divider" tabindex="-1"></li>
                <li><a href="#physical">Physical Items</a></li>
                <li><a href="#soundtracks">Soundtracks</a></li>
                <li><a href="#artbooks">Art Books</a></li>
                <li><a href="#encyclopaediaeorzea">Encyclopaedia Eorzea</a></li>
                <li><a href="#plushes">Plushes</a></li>
                <li class="divider" tabindex="-1"></li>
                <li><a href="#commendations">Comms</a></li>
                <li><a href="#eternal-bond">Eternal Bond</a></li>
                <li><a href="#hildibrand">Hildibrand</a></li>
                <li><a href="#deepdungeon">Deep Dungeon</a></li>
                <li><a href="#vcdungeons">Variant &amp; Criterion Dungeons</a></li>
                <li><a href="#pvp-stats">PvP</a></li>
                <li><a href="#misc-stats">Other Stats</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-content white-text">
                    <span class="card-title light">IMPORTANT ANNOUNCEMENT</span>
                    <div style="text-align: center;">
                        <a class="btn-large" href="https://github.com/XIVStats/XIVStats/issues/57">Statement regarding
                            January 2022 Census and the future of the Census</a>
                    </div>
                    <hr />
                    <br />
                    <a id="population"><span class="card-title light">HOW MANY CHARACTERS ARE THERE?</span></a>
                    <br />
                    <hr />
                    <br />
                    <!--World-->
                    <div class="light region-title">WORLD</div>
                    <div class="light region-subtitle">ALL CHARACTERS</div>
                    <div class="row">
                        <div class="s12 m6 l6   region-stat">
                            <div>
                                <?php echo number_format($player_count) ?>
                            </div>
                        </div>
                    </div>
                    <div class="light region-subtitle">ENDGAME CHARACTERS</div>
                    <div class="row">
                        <div class="s12 m6 l6   region-stat">
                            <div>
                                <?php echo number_format($active_player_count) ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- America -->
                    <div class="row">
                        <a id="popna">
                            <div class="light region-title">AMERICA</div>
                        </a>
                        <div class="col s12 m6 l6 light region-stat">
                            <div class="light region-subtitle">ALL CHARACTERS</div>
                            <div>
                                <?php echo number_format(sumInRegion($realm_count, $american_realm_array)) ?>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 light region-stat">
                            <div class="light region-subtitle">ENDGAME CHARACTERS</div>
                            <div>
                                <?php echo number_format(sumInRegion($active_realm_count, $american_realm_array)) ?>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <!--End America-->
                    <!--Japan-->
                    <div class="row">
                        <a id="popjp">
                            <div class="light region-title">JAPAN</div>
                        </a>
                        <div class="col s12 m6 l6 light region-stat">
                            <div class="light region-subtitle">ALL CHARACTERS</div>
                            <div>
                                <?php echo number_format(sumInRegion($realm_count, $japanese_realm_array)) ?>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 light region-stat">
                            <div class="light region-subtitle">ENDGAME CHARACTERS</div>
                            <div>
                                <?php echo number_format(sumInRegion($active_realm_count, $japanese_realm_array)) ?>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <!--End Japan-->
                    <!--Europe-->
                    <div class="row">
                        <a id="popeu">
                            <div class="light region-title">EUROPE</div>
                        </a>
                        <div class="col s12 m6 l6 light region-stat">
                            <div class="light region-subtitle">ALL CHARACTERS</div>
                            <div>
                                <?php echo number_format(sumInRegion($realm_count, $european_realm_array)) ?>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 light region-stat">
                            <div class="light region-subtitle">ENDGAME CHARACTERS</div>
                            <div>
                                <?php echo number_format(sumInRegion($active_realm_count, $european_realm_array)) ?>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <!--End Europe-->
                    <!--Oceania-->
                    <div class="row">
                        <a id="popoc">
                            <div class="light region-title">OCEANIA</div>
                        </a>
                        <div class="col s12 m6 l6 light region-stat">
                            <div class="light region-subtitle">ALL CHARACTERS</div>
                            <div>
                                <?php echo number_format(sumInRegion($realm_count, $oceanian_realm_array)) ?>
                            </div>
                        </div>
                        <div class="col s12 m6 l6 light region-stat">
                            <div class="light region-subtitle">ENDGAME CHARACTERS</div>
                            <div>
                                <?php echo number_format(sumInRegion($active_realm_count, $oceanian_realm_array)) ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Oceania-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <a id="racegender"><span class="card-title light">RACE AND GENDER DISTRIBUTION</span></a>
                    <br />
                    <hr />
                    <br />
                    <div class="light region-subtitle">ALL CHARACTERS</div>
                    <br />
                    <!-- Begin Chart -->
                    <div id="race_gender_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                    <br />
                    <hr />
                    <br />
                    <div class="light region-subtitle">ENDGAME CHARACTERS</div>
                    <br />
                    <!-- Begin Chart -->
                    <div id="active_race_gender_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <a id="class"><span class="card-title light">CLASS DISTRIBUTION</span></a>
                    <br />
                    <hr />
                    <br />
                    <div class="light region-subtitle">ALL CHARACTERS</div>
                    <br />
                    <!-- Begin Chart -->
                    <div id="class_distribution" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                    <!-- End Chart -->
                    <br />
                    <hr />
                    <br />
                    <div class="light region-subtitle">ENDGAME CHARACTERS</div>
                    <br />
                    <!-- Begin Chart -->
                    <div id="active_class_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <a id="realmall"><span class="card-title light">REALM DISTRIBUTION (ALL)</span></a>
                    <br />
                    <hr />
                    <br />
                    <a id="rat-na">
                        <div class="light region-subtitle">AMERICAN REALMS</div>
                    </a>
                    <br />
                    <!-- Begin Chart -->
                    <div id="america_realm_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                    <br />
                    <hr />
                    <br />
                    <a id="rat-jp">
                        <div class="light region-subtitle">JAPANESE REALMS</div>
                    </a>
                    <br />
                    <!-- Begin Chart -->
                    <div id="japan_realm_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                    <br />
                    <hr />
                    <br />
                    <a id="rat-eu">
                        <div class="light region-subtitle">EUROPEAN REALMS</div>
                    </a>
                    <br />
                    <!-- Begin Chart -->
                    <div id="europe_realm_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                    <br />
                    <hr />
                    <br />
                    <a id="rat-oc">
                        <div class="light region-subtitle">OCEANIAN REALMS</div>
                    </a>
                    <br />
                    <!-- Begin Chart -->
                    <div id="oceanian_realm_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <a id="realmendgame"><span class="card-title light">REALM DISTRIBUTION (ENDGAME)</span></a>
                    <br />
                    <hr />
                    <br />
                    <a id="ra-na">
                        <div class="light region-subtitle">AMERICAN REALMS</div>
                    </a>
                    <br />
                    <!-- Begin Chart -->
                    <div id="america_endgame_realm_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                    <br />
                    <hr />
                    <br />
                    <a id="ra-jp">
                        <div class="light region-subtitle">JAPANESE REALMS</div>
                    </a>
                    <br />
                    <!-- Begin Chart -->
                    <div id="japan_endgame_realm_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                    <br />
                    <hr />
                    <br />
                    <a id="ra-eu">
                        <div class="light region-subtitle">EUROPEAN REALMS</div>
                    </a>
                    <br />
                    <!-- Begin Chart -->
                    <div id="europe_endgame_realm_distribution" style="min-width: 400px; height: 400px; margin: 0 auto">
                    </div>
                    <!-- End Chart -->
                    <br />
                    <hr />
                    <br />
                    <a id="ra-oc">
                        <div class="light region-subtitle">OCEANIAN REALMS</div>
                    </a>
                    <br />
                    <!-- Begin Chart -->
                    <div id="oceanian_endgame_realm_distribution" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                    <!-- End Chart -->
                </div>
            </div>
        </div>
        <div class="row card">
            <div class="card-content">
                <div id="grandcompany" class="col s12"><span class="card-title light">GRAND COMPANY DISTRIBUTION</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m6 l6 light region-subtitle">
                            <p>ALL CHARACTERS</p>
                            <!-- Begin Chart -->
                            <div id="gc_distribution" style="min-width: 300px; height: 300px; margin: 0 auto"></div>
                            <!-- End Chart -->
                        </div>
                        <div class="col s12 m6 l6 light region-subtitle">
                            <p>ACTIVE CHARACTERS</p>
                            <!-- Begin Chart -->
                            <div id="gc_active_distribution" style="min-width: 300px; height: 300px; margin: 0 auto">
                            </div>
                            <!-- End Chart -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <a id="tribal"><span class="card-title light">TRIBAL QUESTS (REDEEMED MOUNT OR MINION)</span></a>
                    <hr />
                    <br />
                    <div class="light region-subtitle">ALL CHARACTERS</div>
                    <br />
                    <!-- Begin Chart -->
                    <div id="beast_tribes" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                    <!-- End Chart -->
                </div>
            </div>
        </div>

        <div class="row card">
            <div class="card-content">
                <div class="col s12"><a id="preorders"></a><span class="card-title light">PRE-ORDERS</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/66241a2923d/"
                                    class="eorzeadb_link">PRE-ORDERED A REALM REBORN</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_prearr; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/924cd368577"
                                    class="eorzeadb_link">PRE-ORDERED HEAVENSWARD</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_prehw; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/fc6c2f880af/"
                                    class="eorzeadb_link">PRE-ORDERED STORMBLOOD</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_presb; ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/1f8e56071f0/"
                                    class="eorzeadb_link">PRE-ORDERED SHADOWBRINGERS</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_preshb; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/b847d7e73de/"
                                    class="eorzeadb_link">PRE-ORDERED ENDWALKER</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_preew; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="#"
                                    class="eorzeadb_link">PRE-ORDERED DAWNTRAIL</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_predt; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row card">
            <div class="card-content">
                <div class="col s12"><a id="collectors"></a><span class="card-title light">COLLECTORS EDITION</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/d2b5911259b/"
                                    class="eorzeadb_link">A REALM REBORN COLLECTORS EDITION</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_arr_collectors; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/df6e606a7e5/"
                                    class="eorzeadb_link">HEAVENSWARD COLLECTORS EDITION</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_hw_collectors; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/bd66e9aee09/"
                                    class="eorzeadb_link">STORMBLOOD COLLECTORS EDITION</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_sb_collectors; ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/3757fa104c4/"
                                    class="eorzeadb_link">SHADOWBRINGERS COLLECTORS EDITION</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_shb_collectors; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/ec641703b2d/"
                                    class="eorzeadb_link">ENDWALKER COLLECTORS EDITION</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_ew_collectors; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="#"
                                    class="eorzeadb_link">DAWNTRAIL COLLECTORS EDITION</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_dt_collectors; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row card">
            <div class="card-content">
                <div class="col s12"><a id="physical"></a><span class="card-title light">PHYSICAL ITEMS</span>
                    <!-- <p>How many people redeemed the minion?</p> -->
                    <hr>
                </div>
                <!-- TEMPLATE FOR EACH ENTRY
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/50fcfd8c8f8/" class="eorzeadb_link">A REALM REBORN SOUNDTRACK</a></p>
                        <span class="region-stat">
                        <?php echo $fmt_arr_soundtrack; ?>
                        </span>
                    </div>
                    -->
                <div class="col s12"><a id="soundtracks"></a><span class="card-title light">Soundtracks</span></div>
                <div class="row">
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/50fcfd8c8f8/"
                                class="eorzeadb_link">A REALM REBORN SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_arr_soundtrack; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/2b1a5517c8d/"
                                class="eorzeadb_link">BEFORE METEOR SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_beforemeteor; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/9dadf106d04/"
                                class="eorzeadb_link">BEFORE THE FALL SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_beforethefall; ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/c690d60dd73/"
                                class="eorzeadb_link">HEAVENSWARD SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_hw_soundtrack; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/049cc50f4d7/"
                                class="eorzeadb_link">FAR EDGE OF FATE SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_faredgeoffate; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/45756aecdd5/"
                                class="eorzeadb_link">STORMBLOOD SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_sb_soundtrack; ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/1e1308a12e2/"
                                class="eorzeadb_link">SHADOWBRINGERS SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_shb_soundtrack; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/eadaf97de6e/"
                                class="eorzeadb_link">DEATH UNTO DAWN SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_deathuntodawn; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/2b855d1b1a1/" class="eorzeadb_link">ENDWALKER SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_ew_soundtrack; ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12 light region-subtitle">
                        <p><a href="#"
                                class="eorzeadb_link">GROWING LIGHT SOUNDTRACK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_growinglight; ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12"><a id="artbooks"></a><span class="card-title light">Art Books</span></div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/eda40ba9cc3/"
                                class="eorzeadb_link">A REALM REBORN ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_arrartbook; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/7f0506ab250/"
                                class="eorzeadb_link">HW STONE &amp; STEEL ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_hw_artbook; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/cdc080f90af/"
                                class="eorzeadb_link">HW SCARS OF WAR ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_hw_artbooktwo; ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/5b97443cede/"
                                class="eorzeadb_link">SB EASTERN MEMORIES ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_sbartbook; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/f9207126370/"
                                class="eorzeadb_link">SB WESTERN MEMORIES ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_sbartbooktwo; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/d3dd79b498c/"
                                class="eorzeadb_link">SHB HISTORIES UNWRITTEN ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_shb_artbook; ?>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/e98b51f6520/"
                                class="eorzeadb_link">SHB HISTORIES FORSAKEN ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_shb_artbooktwo; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/ce5b2d5f679/"
                                class="eorzeadb_link">EW AMONG THE STARS ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_ew_artbook; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="#"
                                class="eorzeadb_link">EW BEYOND THE VEIL ARTBOOK</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_ew_artbooktwo; ?>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12"><a id="encyclopaediaeorzea"></a><span class="card-title light">Encyclopaedia Eorzea</span></div>
                    <!-- Encyclopedia 2 is not here since the reward was a headpiece --> 
                    <div class="col s12 m6 l6 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/d55e4e70d34/"
                                class="eorzeadb_link">ENCYCLOPEDIA EORZEA 1</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_encyclopaediaeorzea_one; ?>
                        </span>
                    </div>
                    <div class="col s12 m6 l6 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/4f479516937/"
                                class="eorzeadb_link">ENCYCLOPEDIA EORZEA 3</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_encyclopaediaeorzea_three; ?>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12"><a id="plushes"></a><span class="card-title light">Plushes</span></div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/a2256ee7ea1/"
                                class="eorzeadb_link">MOOGLE PLUSH</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_moogleplush; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/982e7c79afd/"
                                class="eorzeadb_link">TOPAZ CARBUNCLE PLUSH</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_topazcarbuncle_plush; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-subtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/8fddd620567/"
                                class="eorzeadb_link">EMERALD CARBUNCLE PLUSH</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_emeraldcarbuncle_plush; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row card">
            <div class="card-content">
                <div class="col s12"><a id="commendations"></a><span class="card-title light">COMMENDATIONS</span>
                    <hr>
                    <div class="col s12 m4 l4 light region-medsubtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/86730d8e87e/"
                                class="eorzeadb_link">EARNED 50 COMMENDATIONS</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_comm50; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-medsubtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/e25cb89825b/"
                                class="eorzeadb_link">EARNED 500 COMMENDATIONS</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_comm500; ?>
                        </span>
                    </div>
                    <div class="col s12 m4 l4 light region-medsubtitle">
                        <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/556d57aa8ca/"
                                class="eorzeadb_link">EARNED 3000 COMMENDATIONS</a></p>
                        <span class="region-stat">
                            <?php echo $fmt_comm3000; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row card">
            <div class="card-content">
                <div class="col s12"><a id="eternal-bond"></a><span class="card-title light">ETERNAL BOND</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m6 l6 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/f430030885a/"
                                    class="eorzeadb_link">GUEST AT AN ETERNAL BOND</a> <br /> (Gold &amp; Platinum only)</p>
                            <span class="region-stat">
                                <?php echo $fmt_saw_eternal_bond; ?>
                            </span>
                        </div>
                        <div class="col s12 m6 l6 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/0e108974cc8/"
                                    class="eorzeadb_link">MARRIED AT AN ETERNAL BOND</a> <br /> (Gold &amp; Platinum only)</p>
                            <span class="region-stat">
                                <?php echo $fmt_did_eternal_bond; ?>
                            </span>
                        </div>
                    </div>
                    <a id="hildibrand"></a><span class="card-title light">HILDIBRAND</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/a4ed9096de2/"
                                    class="eorzeadb_link">COMPLETED ARR HILDIBRAND QUESTLINE</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_arr_hildibrand; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/c2f9eda2c29/"
                                    class="eorzeadb_link">COMPLETED HW HILDIBRAND QUESTLINE</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_hw_hildibrand; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/0040a15a6fa/"
                                    class="eorzeadb_link">COMPLETED EW HILDIBRAND QUESTLINE</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_ew_hildibrand; ?>
                            </span>
                        </div>
                    </div>
                    <a id="deepdungeon"></a><span class="card-title light">DEEP DUNGEON</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m12 l12 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/e36a444b624/"
                                    class="eorzeadb_link">OBTAINED 'VINTAGE VOGUE' ACHIEVEMENT</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_vintage_vogue_achievement; ?>
                            </span>
                        </div>
                    </div>
                    <a id="vcdungeons"></a><span class="card-title light">VARIANT &amp; CRITERION DUNGEONS</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/ce47260bd86/"
                                    class="eorzeadb_link">UNLOCK ALL SURVEYS IN SIL'DIHN SUBTERRANE</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_all_survey_sildihn; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/89826f6775d/"
                                    class="eorzeadb_link">UNLOCK ALL SURVEYS IN MOUNT ROKKON</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_all_survey_rokkon; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://na.finalfantasyxiv.com/lodestone/playguide/db/item/840542a5c6a/"
                                    class="eorzeadb_link">UNLOCK ALL SURVEYS IN ALOALO ISLAND</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_all_survey_aloalo; ?>
                            </span>
                        </div>
                    </div>
                    <a id="pvp-stats"></a><span class="card-title light">PLAYER VS PLAYER</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/f1588cffe7b/"
                                    class="eorzeadb_link">WIN 200 'FEAST' OR 'CRYSTALLINE CONFLICT' MATCHES</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_pvp_200_wins; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/b584f30517a/"
                                    class="eorzeadb_link">REACH LV 15</a> OR <a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/790cf2a0925"
                                    class="eorzeadb_link">LV 16 IN SERIES 2 OF PVP</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_pvp_s2l1516_reward; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/54e1efcec9d/"
                                    class="eorzeadb_link">REACH LV 25 IN SERIES 2 OF PVP</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_pvp_s2l25_reward; ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/cf30ad82b8d/"
                                    class="eorzeadb_link">REACH LV 15 IN SERIES 3 OF PVP</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_pvp_s3l15_reward; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/424a7a49fbb/"
                                    class="eorzeadb_link">REACH LV 15 IN SERIES 4 OF PVP</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_pvp_s4l15_reward; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/9d590218ad0/"
                                    class="eorzeadb_link">REACH LV 25 IN SERIES 4 OF PVP</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_pvp_s4l25_reward; ?>
                            </span>
                        </div>
                        <div class="col s12 m12 l12 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/d1365de3a3f/"
                                    class="eorzeadb_link">REACH LV 15 IN SERIES 5 OF PVP</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_pvp_s5l15_reward; ?>
                            </span>
                        </div>
                    </div>
                    <a id="misc-stats"></a><span class="card-title light">OTHER STATS</span>
                    <hr>
                    <div class="row">
                        <div class="col s12 m4 l4 light region-medsubtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/48bcda3953e/"
                                    class="eorzeadb_link">COMPLETED ARR SIGHTSEEING LOG</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_sightseeing; ?>
                            </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/5df3d220ac1/" class="eorzeadb_link">PARTICIPATED IN 9TH ANNIVERSARY EVENT</a></p>
                            <span class="region-stat">
                                <?php echo $fmt_ninth_anniversary; ?>
                                </span>
                        </div>
                        <div class="col s12 m4 l4 light region-subtitle">
                            <p><a href="https://eu.finalfantasyxiv.com/lodestone/playguide/db/item/b62ad975fb7/"
                                    class="eorzeadb_link">LITERAL WHALES THAT WILL BUY ANY MOUNT!</a><br /> (This is meant as a joke. Tee hee!)</p>
                            <span class="region-stat">
                                <?php echo $fmt_literal_whale; ?><br />
                                </span>
                                $<?php echo $literal_whale_in_usd; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row card">
            <div class="card-content">
                <div class="col s12"><span class="card-title light">DELETED CHARACTERS</span>
                    <hr>
                    <div class="col s12 m12 l12 light region-medsubtitle">
                        <span class="region-stat">
                            <?php echo $fmt_deleted; ?>
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <div class="row card">
            <div class="card-content">
                <div class="light region-title"><p><a href="<?php echo "
                                https://s3.eu-west-2.amazonaws.com/ffxivcensus.com/" . date("Y-m") . "/ffxivcensus-" .
                                date("Y-m") . ".zip" ;?>">Download database (MySQL)</a></p></div>
            </div>
            <div class="card-content">
                <span class="card-title light"></span>
                <div class="light region-title"><p><a href="/list">View Previous Censuses</a></p></div>
            </div>
        </div>

        <div class="row card">
            <div class="card-content">
                <div class="col s12"><span class="card-title light">CONTRIBUTIONS</span>
                    <hr>
                </div>
                <div class="row">
                    <ul>
                        <li>
                            <div class="light "><p>> <a href="https://www.linkedin.com/in/jonathanpriceuk/"
                                    target="_blank">Jonathan Price</a> | <a
                                    href="https://na.finalfantasyxiv.com/lodestone/character/8308898/"
                                    target="_blank">John Prycewood @ Cerberus</a></p></div>
                        </li>
                        <li>
                            <div class="light "><p>> <a href="https://twitter.com/ReidWeb" target="_blank">Peter
                                    Reid</a> | <a href="https://eu.finalfantasyxiv.com/lodestone/character/11886902/"
                                    target="_blank">P'tajha Rihll @ Omega</a></p></div>
                        </li>
                        <li>
                            <div class="light "><p>> <a href="https://github.com/matthewhillier" target="_blank">Matt
                                    Hillier</a> | <a href="https://eu.finalfantasyxiv.com/lodestone/character/2256025/"
                                    target="_blank">Russell Tyler @ Omega</a></p></div>
                        </li>
                        <li>
                            <div class="light "><p>> <a href="https://pf.ie">Padraig Fahy</a> | <a
                                    href="https://eu.finalfantasyxiv.com/lodestone/character/1573466/">Crakila
                                    Fors'ee @ Cerberus</a></p></div>
                        </li>
                    </ul>
                </div>
                <div class="col s12"><span class="card-title light">LEGAL</span>
                    <hr>
                </div>
                <p>FFXIV Census is not affiliated with Square Enix.<br />
                    FINAL FANTASY is a registered trademark of Square Enix Holdings Co., Ltd.<br />
                    FINAL FANTASY XIV &copy; 2010-2022 SQUARE ENIX CO., LTD. All Rights Reserved.<br />
                </p>
            </div>
        </div>
    </div>
    </div>
        <!-- End Container -->
    </div>
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
                Statistics generated on
                <?php echo date("Y-m-d");  ?>
                <div class="right"><a class="grey-text text-lighten-4" href="https://github.com/XIVStats">Source Code
                        available on GitHub</a> - Feel free to submit any ideas you may have!</div>
            </div>
        </div>
    </footer>

    <script>
        var mn = $(".navbar");
        mns = "main-nav-scrolled";
        hdr = $('header').height();

        $(window).scroll(function () {
            if ($(this).scrollTop() > 105) {
                mn.addClass(mns);
            } else {
                mn.removeClass(mns);
            }
        });
    </script>

    <script>
        $(function () {
            Highcharts.theme = {
                chart: {
                    backgroundColor: '#303440'
                },

                colors: ['#44aadf', '#702670', '#9E0000', '#0038A8'],

                legend: {
                    itemStyle: {
                        color: '#ffffff'
                    }

                },

                xAxis: {
                    title: {
                        style: {
                            color: '#c3ac5c'
                        }
                    },
                    labels: {
                        style: {
                            color: '#ffffff'
                        }
                    }
                },

                yAxis: {
                    title: {
                        style: {
                            color: '#c3ac5c'
                        }
                    },
                    labels: {
                        style: {
                            color: '#ffffff'
                        }
                    }
                },

                plotOptions: {
                    column: {
                        borderWidth: 0
                    },
                    pie: {
                        borderWidth: 0,
                        colors: ['#212121', '#b71c1c', '#ffc107', '#9e9e9e'],
                        dataLabels: {
                            color: '#ffffff'
                        }
                    }
                },
            };

            Highcharts.setOptions(Highcharts.theme);
        });
    </script>

    <script>
        $(function () {
            $('#gc_distribution').highcharts({
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    type: 'pie',
                    name: '# of Characters',
                    data: [
                      <?php
                              foreach($gc_count as $key => $value) {
                            echo "['" .$key. "', " .getValue($value). "],\n";
                        }
                            ?>
                  ]
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#gc_active_distribution').highcharts({
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    type: 'pie',
                    name: '# of Characters',
                    data: [
                      <?php
                              foreach($active_gc_count as $key => $value) {
                            echo "['" .$key. "', " .getValue($value). "],\n";
                        }
                            ?>
                  ]
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#race_gender_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                colors: ['#ff9933', '#4c5fbf'],
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                      <?php
                              foreach($race_gender_count as $key => $value) {
                            echo "\"$key\",\n";
                        }
                            ?>
                  ],

                },
                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Female',
                    data: [
                      <?php
                              foreach($race_gender_count as $value) {
                            echo getValueFromArray($value, "female") . ",";
                        }
                            ?>
                  ],
                }, {
                    name: 'Male',
                    data: [
                      <?php
                              foreach($race_gender_count as $value) {
                            echo getValueFromArray($value,"male") . ",";
                        }
                            ?>
                  ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#active_race_gender_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                colors: ['#ff9933', '#4c5fbf'],
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                      <?php
                              foreach($active_race_gender_count as $key => $value) {
                            echo "\"$key\",\n";
                        }
                            ?>
                  ],

                },
                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Female',
                    data: [
                      <?php
                              foreach($active_race_gender_count as $value) {
                            echo getValueFromArray($value, "female") . ",";
                        }
                            ?>
                  ],
                }, {
                    name: 'Male',
                    data: [
                      <?php
                              foreach($active_race_gender_count as $value) {
                            echo getValueFromArray($value,"male") . ",";
                        }
                            ?>
                  ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#class_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                      <?php
                          foreach($classes as $key => $value) {
                            echo json_encode($value[TYPE][TITLE]) . ',';
                        }
                            ?>
                  ],

                },
                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Characters',
                    data: [
                      <?php foreach($classes as $key => $value) { ?>
                        { name: <?php echo json_encode($value[TYPE][TITLE]); ?>, y: <?php echo getValue($value[COUNT]); ?>, color: <?php echo json_encode($value[TYPE][COLOR]) ?> },
                      <?php } ?>
                  ],
              }]
          });
      });
    </script>

    <script>
        $(function () {
            $('#active_class_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                      <?php
                          foreach($active_classes as $key => $value) {
                            echo json_encode($value[TYPE][TITLE]) . ',';
                        }
                            ?>
                  ],

                },
                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Active Characters',
                    data: [
                      <?php foreach($active_classes as $key => $value) { ?>
                        { name: <?php echo json_encode($value[TYPE][TITLE]); ?>, y: <?php echo getValue($value[COUNT]); ?>, color: <?php echo json_encode($value[TYPE][COLOR]) ?> },
                      <?php } ?>
                  ]
              }]
          });
      });
    </script>

    <script>
        $(function () {
            $('#america_realm_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                <?php
                        foreach($american_realm_array as $key => $value) {
                            echo "'$value',";
                        }
                            ?>
             ],

                },

                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'All',
                    data: [
                <?php
                        foreach($american_realm_array as $value) {
                            echo getValueFromArray($realm_count, $value) . ",";
                        }
                            ?>
            ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#america_endgame_realm_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                <?php
                        foreach($american_realm_array as $key => $value) {
                            echo "'$value',";
                        }
                            ?>
             ],

                },

                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Active',
                    data: [
                <?php
                        foreach($american_realm_array as $value) {
                            echo getValueFromArray($active_realm_count, $value) . ",";
                        }
                            ?>
            ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#japan_realm_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                <?php
                        foreach($japanese_realm_array as $key => $value) {
                            echo "'$value',";
                        }
                            ?>
             ],

                },

                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'All',
                    data: [
                <?php
                        foreach($japanese_realm_array as $value) {
                            echo getValueFromArray($realm_count, $value) . ",";
                        }
                            ?>
            ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#japan_endgame_realm_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                <?php
                        foreach($japanese_realm_array as $key => $value) {
                            echo "'$value',";
                        }
                            ?>
             ],

                },

                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Active',
                    data: [
                <?php
                        foreach($japanese_realm_array as $value) {
                            echo getValueFromArray($active_realm_count, $value) . ",";
                        }
                            ?>
            ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#europe_realm_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                <?php
                        foreach($european_realm_array as $key => $value) {
                            echo "'$value',";
                        }
                            ?>
             ],

                },

                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'All',
                    data: [
                <?php
                        foreach($european_realm_array as $value) {
                            echo getValueFromArray($realm_count, $value) . ",";
                        }
                            ?>
            ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#europe_endgame_realm_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                <?php
                        foreach($european_realm_array as $key => $value) {
                            echo "'$value',";
                        }
                            ?>
             ],

                },

                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Active',
                    data: [
                <?php
                        foreach($european_realm_array as $value) {
                            echo getValueFromArray($active_realm_count, $value) . ",";
                        }
                            ?>
            ],
                }]
            });
        });
    </script>

<script>
        $(function () {
            $('#oceanian_realm_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                <?php
                        foreach($oceanian_realm_array as $key => $value) {
                            echo "'$value',";
                        }
                            ?>
             ],

                },

                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'All',
                    data: [
                <?php
                        foreach($oceanian_realm_array as $value) {
                            echo getValueFromArray($realm_count, $value) . ",";
                        }
                            ?>
            ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#oceanian_endgame_realm_distribution').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                <?php
                        foreach($oceanian_realm_array as $key => $value) {
                            echo "'$value',";
                        }
                            ?>
             ],

                },

                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Active',
                    data: [
                <?php
                        foreach($oceanian_realm_array as $value) {
                            echo getValueFromArray($active_realm_count, $value) . ",";
                        }
                            ?>
            ],
                }]
            });
        });
    </script>

    <script>
        $(function () {
            $('#beast_tribes').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [
                      <?php
                              foreach($beast_tribes as $key => $value) {
                            echo "'$key',";
                        }
                            ?>
                  ],

                },
                yAxis: {
                    title: {
                        text: '# of Characters'
                    }
                },
                tooltip: {
                    pointFormat: '{point.y}'
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Tribe',
                    data: [
                      <?php
                              foreach($beast_tribes as $key => $value) {
                            echo getValue($value) . ",";
                        }
                            ?>
                  ],
                }]
            });
        });
    </script>


</body>

</html>