<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/
 require_once dirname(__FILE__) . "\57\x2e\x2e\x2f\x2e\56\x2f\x2e\x2e\57\x6c\157\x6e\x61\153\x69\x6e\147\x5f\x66\154\141\163\x68\x2f\x46\154\x61\163\150\x43\x6f\155\x6d\157\156\x53\x65\162\166\151\x63\145\x2e\x70\150\160"; class GiftShopUserService { public function updateUserScore($score, $openid) { goto mWgr9; mWgr9: load()->model("\x6d\x63"); goto Ta5_q; BY51R: mc_credit_update($uid, "\143\162\x65\144\151\164\61", $score); goto DIYyP; Ta5_q: $uid = mc_openid2uid($openid); goto BY51R; DIYyP: } public function fetchUserScore($openid) { goto eaJ9l; YU4fq: $uid = mc_openid2uid($openid); goto UuZBP; UuZBP: $credits = mc_credit_fetch($uid, array("\143\162\145\x64\x69\x74\x31")); goto aLIRT; aLIRT: return $credits["\x63\x72\145\144\151\x74\x31"]; goto xhdbw; eaJ9l: load()->model("\x6d\x63"); goto YU4fq; xhdbw: } public function fetchUserMoney($openid) { goto ynmee; ynmee: load()->model("\x6d\143"); goto KUiLb; RsD21: $credits = mc_credit_fetch($uid, array("\143\x72\145\x64\x69\x74\62")); goto VAQ_l; KUiLb: $uid = mc_openid2uid($openid); goto RsD21; VAQ_l: return $credits["\x63\x72\x65\144\x69\164\62"]; goto FqbjB; FqbjB: } public function fetchUserCredit($openid) { goto JA2Ik; vcsp6: $credits = mc_credit_fetch($uid); goto QaXnX; JA2Ik: load()->model("\x6d\x63"); goto D60U3; QaXnX: return $credits; goto Y8cBB; D60U3: $uid = mc_openid2uid($openid); goto vcsp6; Y8cBB: } }