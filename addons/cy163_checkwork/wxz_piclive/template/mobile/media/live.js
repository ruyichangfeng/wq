$(function() {
	function b(a, c) {
		var f, b, g, n, e, d;
		f = $("#remind-banner");
		b = f.find(".icon_cross");
		g = $("#fansnowball");
		n = g.children(".bg");
		e = g.find(".close");
		d = g.find("#ql-qrcode");
		(function() {
			f.on("click", function(a) {
				g.show()
			});
			b.on("click", function(a) {
				a.stopPropagation();
				f.hide()
			});
			n.on("click", function(a) {
				g.hide()
			});
			e.on("click", function(a) {
				g.hide()
			})
		})();
		(function() {
			$.ajax({
				type: "POST",
				url: "/live/getQr.htm",
				data: {
					channel: "205",
					liveId: c,
					showQl: "Y"
				},
				success: function(a) {
					"200" == a.statusCode ? d.attr("src", a.msg) : $(document).minTipsBox({
						tipsContent: a.msg,
						tipsTime: 1
					})
				},
				error: function() {
					$(document).minTipsBox({
						tipsContent: data.msg,
						tipsTime: 1
					})
				}
			})
		})()
	}
	function h() {
		var a = $(".word_scroll p"),
			c = $(".word_scroll").width(),
			f = a.width();
		--J;
		J < -f && (J = c);
		a.css({
			transform: "translate3D( " + J + "px,0,0)",
			webkitTransform: "translate3D( " + J + "px,0,0)"
		})
	}
	function q() {
		j && (j = !1, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/getTopicList.htm?liveId=" + liveId, {
			page: ab,
			pageSize: 11
		}, function(a, c, f) {
			$(".page_loading_box").hide();
			0 < $("#pageLoadBox dd").length ? ($("#qliveList").append($("#pageLoadBox").html()), j = !0, $("#pageLoadBox").html(""), ab++) : $("#loadNone").show()
		}))
	}
	function d(a) {
		var c = $("#topicMenu").data("thisTopicId"),
			f = B.parents("dd"),
			b = f.parents("#qliveList");
		$.ajax({
			type: "POST",
			url: "/live/channel/removetopic.htm",
			data: {
				topicId: c,
				money: a
			},
			success: function(a) {
				$(".loadingBox").hide();
				if (200 === a.state.code) {
					f.remove();
					var c = Number($(".topic-num").html() - 1);
					$(".topic-num").html(c);
					$("#setOutMoneyBox").hide();
					hideBottomBox();
					refreshPage();
					0 >= b.find("dd").length && b.parents(".topic_list").hide()
				} else alertMsg(a.state.msg, 1);
				$(document).minTipsBox({
					tipsContent: a.state.msg,
					tipsTime: 1
				})
			},
			error: function(a) {
				$(document).minTipsBox({
					tipsContent: a.state.msg,
					tipsTime: 1
				});
				$(".loadingBox").hide()
			}
		})
	}
	function S(a) {
		s && (s = !1, $(".page_loading_box").show(), $.ajax({
			type: "GET",
			url: "/live/channel/changeChannelList.htm",
			data: {
				liveId: liveId,
				page: bb,
				pageSize: Qb
			},
			success: function(c) {
				$(".loadingBox").hide();
				c = c.model.channels;
				if (0 < c.length) {
					for (i = 0; i < c.length; i++) {
						var f = '<li data-id="' + c[i].id + '" >' + c[i].name + "</li>";
						$(".channel_list_box ul").append(f)
					}
					bb++;
					s = !0;
					a && a()
				}
			},
			error: function(a) {
				$(".loadingBox").hide();
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		}))
	}
	function C() {
		if (T) {
			T = !1;
			var a = $("li.qlbga_on").data("id"),
				c = $("#topicMenu").data("thisTopicId");
			$(".loadingBox").show();
			$.ajax({
				type: "POST",
				url: "/live/channel/moveIntoChannel.htm",
				data: {
					channelId: a,
					topicId: c
				},
				success: function(a) {
					$(".loadingBox").hide();
					$(document).minTipsBox({
						tipsContent: a.msg,
						tipsTime: 1
					});
					"200" == a.statusCode ? (hideBottomBox(), $(".moveTopicChannelBox").hide(), setTimeout(function() {
						window.location.reload(!0)
					}, 1E3)) : T = !0
				},
				error: function(a) {
					T = !0;
					$(".loadingBox").hide();
					$(document).minTipsBox({
						tipsContent: a.msg,
						tipsTime: 1
					})
				}
			})
		}
	}
	function va(a) {
		setTimeout(function() {
			window.location.href = "/live/entity/list.htm?liveId=" + a + "&_=" + (new Date).getTime()
		}, 1E3)
	}
	function K(a, c, f, b, g, n) {
		bd && (bd = !1, $.ajax({
			type: "POST",
			url: "/live/entity/add.htm",
			data: {
				logo: a,
				name: c,
				introduce: f,
				wechatAccount: b,
				phoneNum: g,
				createrDuty: n
			},
			success: function(a) {
				$(".loadingBox").hide();
				"200" == a.statusCode ? ($(document).minTipsBox({
					tipsContent: "\u4fdd\u5b58\u6210\u529f",
					tipsTime: 1
				}), window._qla && _qla("event", {
					category: "createLive",
					action: "success",
					trace: sessionStorage.getItem("trace") || "normal",
					liveId: a.liveEntityView.id
				}), va(a.liveEntityView.id)) : (bd = !0, $(document).popBox({
					boxContent: a.msg,
					btnType: "confirm"
				}))
			},
			error: function() {
				window._qla && _qla("event", {
					category: "createLive",
					action: "failed",
					trace: sessionStorage.getItem("trace") || "normal"
				});
				$(".loadingBox").hide()
			}
		}))
	}
	function E() {
		var a = window.location.pathname,
			c, f;
		0 < a.lastIndexOf("manage/") ? (c = a.lastIndexOf("."), f = a.lastIndexOf("manage/") + 7) : 0 < a.lastIndexOf("live/") ? (c = a.lastIndexOf("/"), f = a.lastIndexOf("live/") + 5) : (c = a.lastIndexOf("."), f = a.lastIndexOf("/") + 1);
		return a = a.substring(f, c)
	}
	function u() {
		if (U) {
			var a = $(".change_personal_logo img").attr("src").replace(/(@)\w*/, ""),
				c = $(".userNameValue").val().replace(/\\/g, "\\");
			validLegal("text", "\u540d\u79f0", c, 14) && (U = !1, $.ajax({
				type: "GET",
				url: "/user/updateInfo.htm",
				data: {
					name: c,
					headImgUrl: a
				},
				success: function(c) {
					if ("200" == c.msgCode) switch ($(document).minTipsBox({
						tipsContent: "\u4fdd\u5b58\u6210\u529f",
						tipsTime: 1
					}), $(".changePersonalLogo img").attr("src", a), $(".changeUserHeadBox").hide(), window.target) {
					case "mine":
						window.location.href = "/wechat/page/mine?restime=" + (new Date).getTime();
						break;
					case "topic":
						window.location.href = "/topic/" + window.topicId + ".htm?restime=" + (new Date).getTime()
					} else $(document).minTipsBox({
						tipsContent: c.msg,
						tipsTime: 1
					});
					U = !0
				},
				error: function() {
					U = !0
				}
			}))
		}
	}
	function V(a) {
		$.ajax({
			type: "POST",
			url: "/live/entity/modify.htm",
			data: {
				liveId: $(".changePromote").attr("attr-id"),
				type: "recommend",
				value: a
			},
			success: function(c) {
				"200" == c.statusCode ? ("Y" == a ? $(".changePromote p").html("\u662f") : $(".changePromote p").html("\u5426"), $(".changePromote").attr("attr-ison", a), $(".changePromoteBox").hide(), $(document).minTipsBox({
					tipsContent: "\u4fdd\u5b58\u6210\u529f",
					tipsTime: 1
				}), refreshPage()) : $(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				})
			},
			error: function() {
				$(document).minTipsBox({
					tipsContent: data.msg,
					tipsTime: 1
				})
			}
		})
	}
	function xa(a) {
		bg && (bg = !1, $.ajax({
			type: "POST",
			url: "/live/invite/addGuest.htm",
			data: {
				topicId: topicId,
				userId: a.attr("attr-userId")
			},
			success: function(c) {
				bg = !0;
				var f = c.data;
				"200" == c.state.code ? (c = a.parents("dd"), c.append('<span class="people_title">\u5609\u5bbe</span><a href="javascript:;" class="people_set">\u8bbe\u7f6e</a>'), a.remove(), c.find(".people_pic").attr("attr-id", f.guestInviteId), $("#current-guest-box").append(c)) : alertMsg(c.state.msg, 1)
			}
		}))
	}
	function L() {
		y && (y = !1, 0 < $(".allMyLiveRoomList").length && ($(".page_loading_box").show(), W++, $("#pageLoadBox").load("/live/entity/myLiveList.htm", {
			isFollow: "N",
			page: W,
			pageSize: 15,
			role: "manager"
		}, function(a, c, f) {
			$(".page_loading_box").hide();
			0 < $("#pageLoadBox dd").length ? ($(".allMyLiveRoomList").append($("#pageLoadBox").html()), y = !0) : (y = !1, $("#loadNone").show())
		})), 0 < $(".lastMyLiveRoomList").length && ($(".page_loading_box").show(), W++, $("#pageLoadBox").load("/live/entity/myLiveList.htm", {
			isFollow: "N",
			page: W,
			pageSize: 20,
			role: "lastBrowse"
		}, function(a, c, f) {
			$(".page_loading_box").hide();
			0 < $("#pageLoadBox dd").length ? ($(".lastMyLiveRoomList").append($("#pageLoadBox").html()), y = !0) : (y = !1, $("#loadNone").show())
		})), 0 < $(".attendLiveRoomList").length && "Y" == X && ($(".page_loading_box").show(), cb++, $("#pageLoadBox").load("/live/entity/myLiveList.htm", {
			isFollow: "Y",
			page: cb,
			pageSize: 20
		}, function(a, c, f) {
			$(".page_loading_box").hide();
			0 < $("#pageLoadBox dd").length ? ($("#attendLiveRoomList").append($("#pageLoadBox").html()), y = !0) : $("#loadNone").show()
		})), $("#pageLoadBox").html(""))
	}
	function M(a, c) {
		if (r) r = !1, a = (100 * Number(a)).toFixed(0), $.ajax({
			type: "POST",
			url: "/live/pay/tixian.htm",
			data: {
				liveId: liveId,
				total_fee: a,
				name: c
			},
			success: function(a) {
				"200" == a.statusCode ? $(document).popBox({
					boxContent: a.msg,
					btnType: "confirm",
					confirmName: "\u77e5\u9053\u4e86",
					isNeedBg: !1,
					confirmFunction: function() {
						window.location.reload(!0)
					}
				}) : ($(document).popBox({
					boxContent: a.msg,
					btnType: "confirm",
					confirmName: "\u77e5\u9053\u4e86",
					isNeedBg: !1
				}), r = !0)
			},
			error: function() {
				$(document).popBox({
					boxContent: "\u7cfb\u7edf\u6545\u969c\uff0c\u7ef4\u62a4\u4e2d",
					btnType: "confirm",
					confirmName: "\u77e5\u9053\u4e86",
					isNeedBg: !1
				});
				r = !0
			}
		});
		else return r = !0, !1
	}
	function za(a, c, f) {
		if (r) r = !1, $.ajax({
			type: "POST",
			url: "/live/reward/saveRealName.htm",
			data: {
				operAccountId: a,
				recordId: c,
				name: f
			},
			success: function(a) {
				"200" == a.statusCode ? ($(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				}), window.location.reload(!0)) : ($(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				}), r = !0)
			},
			error: function() {
				$(document).minTipsBox({
					tipsContent: "\u7cfb\u7edf\u6545\u969c\uff0c\u7ef4\u62a4\u4e2d",
					tipsTime: 1
				});
				r = !0
			}
		});
		else return r = !0, !1
	}
	function p(a, c, f) {
		var b = Number($(".rewardpercent var").text().split("%")[0]),
			g = $(".introduction_texts").val(),
			n = $(".introduction_pic img").attr("src") ? $(".introduction_pic img").attr("src") : "",
			e = $(".rewardPrice p").data("price"),
			d = !0;
		"N" == a && (d = validLegal("text", "\u8d5e\u8d4f\u9875\u4ecb\u7ecd\u8bed", g, 25));
		g = {
			liveId: liveId,
			rewardIntroduce: g,
			rewardPic: n,
			rewardPrice: e
		};
		if (f || $(".rewardpercent").data("fristpercent") != $(".rewardpercent var").text()) g.businessOpProfit = b, g.isEnable = a;
		d && Y && (Y = !1, $(".loadingBox").show(), $.ajax({
			type: "POST",
			url: "/live/entity/updatePercentageRule.htm",
			data: g,
			success: function(a) {
				$(".loadingBox").hide();
				Y = !0;
				"200" == a.statusCode ? "function" == typeof c && c() : $(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			},
			error: function(a) {
				Y = !0;
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				});
				$(".loadingBox").hide()
			}
		}))
	}
	function e(a) {
		$(".loadingBox").show();
		z && (z = !1, $.ajax({
			type: "POST",
			url: "/live/topic/addorupdate.htm",
			data: a,
			success: function(c) {
				"200" == c.statusCode ? ($(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				}), setTimeout(function() {
					window.location.href = "/topic/" + c.liveTopicView.id + ".htm?preview=Y"
				}, 150), a.topicId || sendPiwikAddTopicEventLog()) : ($(".loadingBox").hide(), z = !0, $(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				}))
			},
			error: function(a) {
				z = !0;
				$(".loadingBox").hide();
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		}))
	}
	function l(a, c) {
		$(document).minTipsBox({
			tipsContent: "\u4ed8\u8d39\u6210\u529f",
			tipsTime: 1
		});
		refreshPage();
		switch (A) {
		case "COURSE_FEE":
			0 < $("#ChannelRoom").length && (window.location.href = "/wechat/page/finish-pay?type=topic&id=" + c.topicId + "&liveId=" + window.liveId);
			break;
		case "CHANNEL":
			setTimeout(function() {
				window.location.href = "/wechat/page/finish-pay?type=channel&id=" + c.channelId + "&liveId=" + window.liveId
			}, 1E3);
			break;
		case "GIFT":
		case "GIFT_CHANNEL":
			$(".giftPack, .payQrBox").hide(), qlSlBoxShow(".giftOver"), $.ajax({
				url: "/live/gift/gid.htm",
				data: {
					orderId: a
				},
				success: function(a) {
					200 === a.state.code && $("#viewGift").attr("data-gift-id", a.data)
				},
				complete: function() {
					$(".loadingBox").hide()
				}
			})
		}
	}
	function t(a) {
		$.ajax({
			type: "POST",
			url: "/live/grant.htm",
			success: function(c) {
				"200" == c.statusCode && a()
			},
			error: function() {}
		})
	}
	function Aa(a, c, f, b, g) {
		$.ajax({
			type: "POST",
			url: "/live/getQr.htm",
			data: {
				channel: c,
				topicId: "",
				liveId: f,
				toUserId: "",
				showQl: b
			},
			success: function(c) {
				"200" == c.statusCode ? $(a).find("img").attr("src", c.msg) : $(a).find("img").attr("src", "//open.weixin.qq.com/qr/code/?username=qianliaoEdu");
				void 0 != g && "" != g && g()
			},
			error: function(a) {
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		})
	}
	function Ba() {
		/.*(recommend|subscribe\-period\-time).*/.test(sessionStorage.getItem("trace_page")) ? "0" == isFollowedQl && Aa(".focusQr2Box", "101", liveId, "Y", function() {
			qlSlBoxShow(".focusQr2Box")
		}) : isBindThird && "0" == isFollowedThird ? Aa(".focusQr2Box", "101", liveId, "N", function() {
			qlSlBoxShow(".focusQr2Box")
		}) : "0" == isFollowedQl && Aa(".focusQr2Box", "101", liveId, "Y", function() {
			qlSlBoxShow(".focusQr2Box")
		})
	}
	function Rb() {
		var a, c, f = Number($(".followers").text());
		"\u5173\u6ce8" == $.trim($(".stlbtn_follow").text()) ? (a = "no", c = "\u5df2\u5173\u6ce8", f += 1) : (a = "yes", c = "\u5173\u6ce8", --f);
		0 > f && (f = 0);
		followLive(a, "", function() {
			$(".stlbtn_follow").toggleClass("active");
			$(".stlbtn_follow").html(c);
			$(".followers").text(f);
			$(document).minTipsBox({
				tipsContent: "\u64cd\u4f5c\u6210\u529f",
				tipsTime: 1
			});
			0 < $(".set_remind").length && "yes" == a ? ("0" == isFollowedQL, $(".set_remind").html('<i class="icon_ring2"></i> \u5f00\u542f\u901a\u77e5'), $(".set_remind").removeClass("reminded")) : 0 < $(".set_remind").length && "no" == a && ("1" == isFollowedQL, $(".set_remind").html('<i class="icon_ring2"></i> \u5df2\u5f00\u542f\u901a\u77e5'), $(".set_remind").addClass("reminded"));
			isFocus = "no" == a ? "true" : "false";
			$(".stlbtn_follow").hasClass("active") && Ba()
		})
	}
	function db(a, c, f) {
		$.ajax({
			type: "POST",
			url: "/live/saveGuide.htm",
			data: {
				key: a,
				type: "LIVE",
				isEnable: "Y" == f ? "Y" : "N",
				liveId: liveId
			},
			success: function(a) {
				"200" == a.statusCode ? ($(".geneBox").hide(), $("." + c + "func_btn").hide()) : $(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			},
			error: function(a) {
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		})
	}
	function Sb(a, c, f, b) {
		Z && (Z = !1, $.ajax({
			type: "POST",
			url: "/live/entity/modify.htm",
			data: {
				liveId: a,
				type: "account",
				wechatAccount: c,
				phoneNum: f,
				createrDuty: b
			},
			success: function(c) {
				"200" == c.statusCode ? ($(document).minTipsBox({
					tipsContent: "\u4fdd\u5b58\u6210\u529f",
					tipsTime: 1
				}), window.location.href = "/live/entity/list.htm?liveId=" + a + "&_=" + (new Date).getTime()) : $(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				});
				Z = !0
			},
			error: function(a) {
				Z = !0
			}
		}))
	}
	function eb(a) {
		bz && (bz = !1, $.ajax({
			type: "POST",
			url: "/topic/share/change/share.htm",
			data: {
				topicId: topicId,
				status: a
			},
			success: function(a) {
				"200" == a.statusCode && ($("#distributeSwitch").toggleClass("swon"), refreshPage());
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				});
				bz = !0
			}
		}))
	}
	function fb(a) {
		var c = "",
			f, b;
		"\u5173\u6ce8" == $.trim($(".fromlive_focus").text()) ? (c = "no", b = "\u5df2\u5173\u6ce8", f = "Y") : (c = "yes", b = "\u5173\u6ce8", f = "N");
		followLive(c, topicId, function() {
			$(".fromlive_focus").toggleClass("on");
			$(".fromlive_focus").text(b);
			isFocus = f;
			$(document).minTipsBox({
				tipsContent: "\u64cd\u4f5c\u6210\u529f",
				tipsTime: 1
			});
			"function" == typeof a && a()
		})
	}
	function gb(a) {
		var c = "";
		"vip" === couponType ? c = "/live/vipCoupon/switchCoupon.htm" : "channel" === couponType && (c = "/live/channel/switchChannelCoupon.htm");
		$.ajax({
			type: "POST",
			url: c,
			data: {
				channelId: window.channelId,
				liveId: window.liveId,
				status: a
			},
			success: function(c) {
				"200" == c.state.code ? ($("#channel_cuppon_switch").attr("attr-ison", a), $(document).minTipsBox({
					tipsContent: "\u4fdd\u5b58\u6210\u529f",
					tipsTime: 1
				}), refreshPage()) : $(document).minTipsBox({
					tipsContent: c.state.msg,
					tipsTime: 1
				})
			},
			error: function() {
				$(document).minTipsBox({
					tipsContent: data.state.msg,
					tipsTime: 1
				})
			}
		})
	}
	function Tb() {
		var a = getSharePercent(topicId);
		wx.hideOptionMenu();
		0 < a ? ($("#percent_input").val(a), $(".percent_tips_var1").text(a), $(".percent_tips_var2").text((99.4 - a).toFixed(1)), $(".percent_tips").show(), $(".share_tips span").html(a).show()) : $(".share_tips span").html("0").hide()
	}
	function Ub() {
		function a() {
			$(".channel-marketing-auto-share").addClass("isPin");
			$("#channel-marketing-type-setting").addClass("isPin");
			$("#channel-marketing-group-charge").addClass("isPin");
			$("#group-section-container .nav_list").addClass("isPin");
			$("#group-section-container").show();
			$("#channel-marketing-type-setting .pin").show();
			$(".pinke").show();
			$(".notpinke").hide();
			$("#btnQuickOpen").hide();
			$("#channel-marketing-type-setting .pin").show();
			$("#channel-marketing-type-setting .te").hide()
		}
		function c() {
			$(".channel-marketing-auto-share").removeClass("isPin");
			$("#channel-marketing-type-setting").removeClass("isPin");
			$("#channel-marketing-group-charge").removeClass("isPin");
			$("#group-section-container .nav_list").addClass("isPin");
			$("#channel-marketing-type-setting .pin").hide();
			$("#group-section-container").hide();
			$(".pinke").hide();
			$(".notpinke").show();
			$("#btnQuickOpen").show()
		}
		function f() {
			$("#channel-marketing-type-setting").removeClass("isTe");
			$("#discount-section-container").hide();
			$("#channel-marketing-type-setting .te").hide()
		}(function() {
			var a = $("#channel-post-uploader-target"),
				c = a.find(".post-preview"),
				f = a.find(".post-preview-tip");
			0 < a.length && new imgUpload(a, {
				folder: "channelLogo",
				onComplete: function(a) {
					console.log("imgUrl", a);
					c.attr("src", a + "@250h_250w_1e_1c_2o");
					c.show();
					f.show()
				}
			})
		})();
		(function() {
			var c = $("#channel-chargetype-setting"),
				b = $("#charge-type-text"),
				n = $("#charge-type-row-absolutely"),
				e = $("#charge-type-row-flexible"),
				d = $("#group-container"),
				l = $("#btnQuickOpen"),
				F = $("#charge-type-modal"),
				p = F.find("#charge-type-modal-list li"),
				t = F.find(".tlbtn_cancel"),
				h = F.find(".tlbtn_confirm");
			c.click(function() {
				$("#charge-type-text").data("canchange") && (qlSlBoxShow("#charge-type-modal"), $("#charge-type-modal-list li[data-type='" + b.data("type") + "']").click())
			});
			p.click(function() {
				$(this).siblings("li").removeClass("active");
				$(this).addClass("active")
			});
			t.click(function() {
				F.hide()
			});
			h.click(function() {
				var a = F.find("#charge-type-modal-list .active");
				if (a.length) {
					var c = a.data("type");
					b.text(a.text());
					b.data("type", c);
					"absolutely" == c ? (e.addClass("hide"), n.removeClass("hide"), d.show()) : "flexible" == c ? (n.addClass("hide"), e.removeClass("hide"), d.hide()) : console.log("where's the fucking type?")
				}
				F.hide()
			});
			l.click(function() {
				$(this).hide();
				$("#channel-marketing-type-text").attr("data-type", "P");
				$("#channel-marketing-type-text").data("type", "P");
				$("#channel-marketing-type-text").html("\u62fc\u8bfe");
				$("#group-section-container").show();
				a();
				f()
			});
			e.click(function() {
				qlSlBoxShow(".setFlexibleBox")
			})
		})();
		(function() {
			var b = $("#channel-marketing-type-setting"),
				g = $("#channel-marketing-type-text"),
				n = $("#marketing-type-modal"),
				e = n.find("tlbtn_cancel"),
				d = n.find(".tlbtn_confirm"),
				l = n.find("#marketing-type-modal-list li");
			$("#group-section-container");
			$("#discount-section-container");
			b.click(function() {
				qlSlBoxShow("#marketing-type-modal");
				console.log($("#channel-marketing-type-text").attr("data-type"));
				$("#marketing-type-modal-list li[data-type='" + $("#channel-marketing-type-text").attr("data-type") + "']").addClass("active").siblings("li").removeClass("active")
			});
			e.click(function() {
				n.hide()
			});
			l.click(function() {
				var a = $(this);
				a.siblings("li").removeClass("active");
				a.addClass("active")
			});
			d.click(function() {
				var b = n.find("li.active");
				b.attr("data-type");
				g.text(b.text());
				g.attr("data-type", b.attr("data-type"));
				g.data("type", b.attr("data-type"));
				switch (b.attr("data-type")) {
				case "Y":
					c();
					$("#channel-marketing-type-setting").addClass("isTe");
					$("#discount-section-container").show();
					$("#channel-marketing-type-setting .te").show();
					break;
				case "P":
					a();
					f();
					break;
				case "N":
					c(), f()
				}
				n.hide()
			})
		})();
		(function() {
			var a = $("#channel-marketing-group-setting"),
				c = $("#channel-marketing-group-member"),
				b = $("#group-member-modal"),
				f = b.find(".qlMT_input"),
				e = b.find(".tlbtn_cancel"),
				d = b.find(".tlbtn_confirm");
			a.click(function(a) {
				b.show()
			});
			e.click(function(a) {
				b.hide()
			});
			d.click(function(a) {
				a = f.val().trim();
				isNumberValid(a, 2, 50, "\u62fc\u8bfe\u4eba\u6570") && (c.text(a), b.hide())
			})
		})()
	}
	function hb(a, c) {
		var b;

		function k() {
			var a = $("#charge-type-text").data("type"),
				c;
			if ("flexible" == a) c = $("#channel-flexible-charge-text").data("chargeConfigs");
			else if ("absolutely" == a) c = $("#charge-type-row-absolutely .channel-setting-charge-input").val().trim(), c = "" != c ? Number(c).toFixed(2) : "";
			else return alertMsg("\u8bf7\u586b\u5199\u6536\u8d39\u6807\u51c6"), !1;
			var f = $("#charge-type-row-absolutely").attr("attr-discount"),
				k = $("#charge-type-row-absolutely").attr("attr-groupnum");
			$("#charge-type-row-absolutely").attr("attr-discount-status");
			if (c) {
				if (f && f > Number(c)) return k && 0 < k ? alertMsg("\u95e8\u7968\u4ef7\u683c\u4e0d\u80fd\u4f4e\u4e8e\u62fc\u8bfe\u4f18\u60e0\u4ef7\u683c") : alertMsg("\u95e8\u7968\u4ef7\u683c\u4e0d\u80fd\u4f4e\u4e8e\u7279\u4ef7\u4f18\u60e0\u4ef7\u683c"), !1;
				b = c
			} else return alertMsg("\u8bf7\u586b\u5199\u95e8\u7968\u4ef7\u683c"), !1;
			f = $("#channel-marketing-type-text");
			if ("P" === f.data("type") && "absolutely" == a) {
				if ("" != c && 1 > c) return alertMsg("\u62fc\u8bfe\u7c7b\u578b\u7684\u7cfb\u5217\u8bfe\u95e8\u7968\u5e94\u8be5\u4e0d\u5c0f\u4e8e1\u5143"), !1;
				k = $("#channel-marketing-group-input").val().trim();
				k = Number(Number(k).toFixed(2));
				if ("" != c && k >= c) return alertMsg("\u62fc\u8bfe\u4f18\u60e0\u4ef7\u683c\u9700\u5c0f\u4e8e\u7cfb\u5217\u8bfe\u7968\u4ef7"), !1;
				if (.01 > k) return alertMsg("\u62fc\u8bfe\u4f18\u60e0\u4ef7\u683c\u9700\u5927\u4e8e0.01\u5143"), !1;
				if ("\u672a\u8bbe\u7f6e" == $("#channel-marketing-group-member").text()) return $("#channel-marketing-group-member").css("color", "#f40").get(0).scrollIntoView(), alertMsg("\u8bf7\u8bbe\u7f6e\u62fc\u8bfe\u4eba\u6570"), !1;
				$("#channel-marketing-group-member").css("color", "#909499")
			}
			if ("Y" === f.data("type") && "absolutely" === a) {
				a = $("#channel-marketing-discount-input").val().trim();
				if ("" != c && 1 > c) return alertMsg("0\u5143\u7cfb\u5217\u8bfe\u4e0d\u80fd\u8bbe\u7f6e\u4f18\u60e0"), !1;
				if (!a) return alertMsg("\u8bf7\u8f93\u5165\u7279\u4ef7\u4f18\u60e0\u4ef7\u683c"), !1;
				if ("" != c && a > Number(c)) return alertMsg("\u95e8\u7968\u4ef7\u683c\u4e0d\u80fd\u4f4e\u4e8e\u4f18\u60e0\u4ef7\u683c"), !1
			}
			return !0
		}
		function g() {
			var a = {},
				c = [];
			a.chargeType = $("#charge-type-text").data("type");
			a.isOpenShare = $("#channel-marketing-auto-share .autoSubscribeSwitch").hasClass("swon") ? "Y" : "N";
			"Y" === a.isOpenShare && (a.autoSharePercent = $(".autoSubscribeValue").val().trim());
			if ("absolutely" == a.chargeType) {
				var f = {
					amount: b,
					channelId: channelId,
					chargeMonths: 0
				},
					k = $("#channel-marketing-type-text").attr("data-type"),
					g = $("#charge-type-row-absolutely").attr("attr-discount"),
					e = $("#charge-type-row-absolutely").attr("attr-groupnum"),
					n = $("#charge-type-row-absolutely").attr("attr-discount-status");
				g && ("P" === n && (f.discountStatus = n, f.discount = g, f.groupNum = e), "Y" === n && (f.discountStatus = n, f.discount = g));
				"P" === k && (f.discountStatus = $(".changeFreeSwitch").hasClass("swon") ? k : "GP", f.discount = $("#channel-marketing-group-input").val().trim(), f.groupNum = $("#channel-marketing-group-member").text());
				"Y" === k && (f.discountStatus = k, f.discount = $("#channel-marketing-discount-input").val().trim());
				c.push(f)
			}
			"flexible" == a.chargeType && (f = b.split(";"), f = f.forEach(function(a, f) {
				a = a.split(",");
				c.push({
					channelId: channelId,
					amount: a[0],
					chargeMonths: a[1]
				})
			}));
			f = $("#channel-post-uploader-target > img").attr("src");
			a.headImage = "" != f ? f.replace(/@\w*/, "") : "https://img.qlchat.com/qlLive/liveCommon/channelNormal.png";
			a.headImage = a.headImage || "https://img.qlchat.com/qlLive/liveCommon/default-channel-img" + (~~ (3 * Math.random(10) + 1) + ".jpg");
			a.id = window.channelId;
			a.description = d;
			a.liveId = window.liveId;
			a.name = l;
			a.chargeConfigs = c;
			a.tagId = $(".btnChannelType").attr("attr-type") || "";
			a.planCount = "\u672a\u8bbe\u7f6e" != p ? $(".btnChannelTopics p").text() : "0";
			return JSON.stringify(a)
		}
		var e = {};
		b = void 0;
		var d = $(".btnChannelIntroduce").text(),
			l = $(".btnChannelName").text().trim();
		"\u672a\u8bbe\u7f6e" == l && (l = "");
		var p = $(".btnChannelTopics p").text(),
			e = !0;
		"\u672a\u8bbe\u7f6e" != p && (e = isNumberValid(Number(p), 1, 9999, "\u5f00\u8bfe\u7684\u8282\u6570"));
		"Y" === ($("#channel-marketing-auto-share .autoSubscribeSwitch").hasClass("swon") ? "Y" : "N") && (autoSharePersent = $(".autoSubscribeValue").val().trim(), e = isNumberValid(Number(autoSharePersent), 1, 80, "\u81ea\u52a8\u5206\u9500\u5206\u6210\u6bd4\u4f8b"));
		chargeConf = $("#charge-type-row-absolutely .channel-setting-charge-input").val().trim();
		chargeConf = Number(chargeConf).toFixed(2);
		validLegal("text", "\u7cfb\u5217\u8bfe\u540d\u79f0", l, 40) && e && k() && bG && (bG = !1, $(".loadingBox").show(), e = g(), $.ajax({
			type: "POST",
			url: "/live/channel/saveChannel.htm",
			data: e,
			contentType: "application/json",
			success: function(f) {
				$(".loadingBox").hide();
				"200" == f.statusCode ? ($(document).minTipsBox({
					tipsContent: f.msg,
					tipsTime: .5
				}), setTimeout(function() {
					a && "Y" == a ? c() : window.location.href = "/live/channel/channelPage/" + channelId + ".htm"
				}, 500)) : (bG = !0, $(document).minTipsBox({
					tipsContent: f.msg,
					tipsTime: 1
				}))
			},
			error: function(a) {
				bG = !0;
				$(".loadingBox").hide();
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		}))
	}
	function Vb(a) {
		if (1 === a.length && 0 === a[0].chargeMonths) {
			$("#charge-type-row-absolutely").find("input").val(a[0].amount);
			var c = a[0].discountStatus,
				f = a[0].discount,
				b = a[0].groupNum;
			$("#charge-type-row-absolutely").attr("attr-discount-status", c);
			$("#charge-type-row-absolutely").attr("attr-discount", f);
			$("#charge-type-row-absolutely").attr("attr-groupnum", b)
		} else {
			var g = "",
				e = "";
			a.forEach(function(c, f) {
				2 > f && (g += "\uffe5" + c.amount + "/" + c.chargeMonths + "\u6708 ");
				e += c.amount + "," + c.chargeMonths;
				f < a.length - 1 && (e += ";")
			});
			$("#channel-flexible-charge-text").text(g);
			$("#channel-flexible-charge-text").data("chargeConfigs", e)
		}
	}
	function Wb() {
		bH && (bH = !1, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/channel/getChannelList.htm?liveId=" + liveId, {
			page: ib,
			pageSize: 20
		}, function(a, c, f) {
			$(".page_loading_box").hide();
			0 < $("#pageLoadBox dd").length ? ($("#channelListDl").append($("#pageLoadBox").html()), bH = !0, $("#pageLoadBox").html(""), ib++) : $("#loadNone").show()
		}))
	}
	function jb() {
		bI && !Ea && (bI = !1, $(".page_loading_box").show(), $.ajax({
			type: "GET",
			url: "/live/channel/getTopicsInChannel.htm",
			data: {
				channelId: channelId,
				page: loadCnTopicPage,
				pageSize: topicPageSize
			},
			success: function(a) {
				bI = !0;
				$(".page_loading_box").hide();
				var c = a.data;
				if (200 == a.state.code) {
					for (var f = 0; f < a.data.length; f++) c[f].isManeger = isManege, c[f].formateTime = c[f].startTime.substring(5, 16), currentTimeMillis >= c[f].startTimeStamp && (c[f].isgoing = "Y"), c[f].peopleNumFormate = 1E4 < c[f].browseNum ? (c[f].browseNum / 1E4).toFixed(2) + "\u4e07" : 0 < c[f].browseNum ? c[f].browseNum : 0;
					0 < c.length ? (a = template("tpl-item-list", {
						data: c
					}), $("#NqChannelList").append(a), c.length < topicPageSize && (Ea = !0, $("#loadNone").show()), loadCnTopicPage++) : (1 === loadCnTopicPage ? $("#channel_none").show() : $("#loadNone").show(), Ea = !0)
				} else alertMsg(a.state.msg)
			},
			error: function(a) {
				bI = !0;
				$(".page_loading_box").hide();
				alertMsg(a.state.msg)
			}
		}))
	}
	function kb(a) {
		$.ajax({
			type: "post",
			url: "/live/channel/orderfree.htm",
			data: {
				chargeConfigId: a
			},
			success: function(a) {
				$(".loadingBox").hide();
				200 === a.state.code ? (alertMsg("\u62a5\u540d\u6210\u529f"), window.location.reload(!0)) : alertMsg(a.state.msg)
			},
			error: function(a) {
				$(".loadingBox").hide();
				alertMsg(a.state.msg)
			}
		})
	}
	function Xb() {}
	function Yb() {
		$(".loadingBox").show();
		var a = $("dd.webkitBox.channel-on-option").attr("data-channel-id") || activeChannel.id,
			c = window.activeChannelTypes && window.activeChannelTypes.id;
		$.ajax({
			type: "POST",
			url: "/live/channel/remove.htm",
			data: {
				channelId: a,
				tagId: c ? 0 == c.id ? null : c : null
			},
			success: function(a) {
				$(".loadingBox").hide();
				alertMsg(a.state.msg);
				200 === a.state.code && ($("dd.webkitBox.channel-on-option").remove(), window.location.reload(), refreshPage(), hideBottomBox("#channel-options"))
			},
			error: function(a) {
				$(".loadingBox").hide();
				alertMsg(a.state.msg)
			}
		})
	}
	function lb(a, c, f) {
		$.ajax({
			type: "GET",
			url: "/api/wechat/live/getRealStatus",
			data: {
				liveId: a,
				type: c
			},
			success: function(a) {
				a = JSON.parse(a);
				0 == a.state.code ? f && f(a.data.status, a.data.isPop) : f && f(!1)
			},
			error: function(a) {
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				});
				N = !0;
				$(".loadingBox").hide()
			}
		})
	}
	function Fa() {
		bS && (bS = !1, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/getPayPeople.htm", {
			topicId: topicId,
			page: bT,
			pageSize: 20,
			key: da
		}, function(a, c, f) {
			$(".page_loading_box").hide();
			bT++;
			0 < $("#pageLoadBox li").length ? ($(".payPeopleListBox").append($("#pageLoadBox").html()), bS = !0, $("#pageLoadBox").html("")) : $("#loadNone").show()
		}))
	}
	function Ha() {
		bU && (bU = !1, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/channel/memberList.htm?channelId=" + channelId, {
			liveId: liveId,
			page: Ia,
			pageSize: 20,
			key: da
		}, function(a, c, f) {
			$(".page_loading_box").hide();
			0 < $("#pageLoadBox dd").length ? ($("#memberPage_dl").append($("#pageLoadBox").html()), bU = !0, $("#pageLoadBox").html(""), Ia++) : $("#loadNone").show()
		}))
	}
	function mb() {
		da = $(".member-search-name").val();
		$("#loadNone").hide();
		"topic" == manageType ? (bS = !0, bT = 1, $(".payPeopleListBox").html(""), Fa(), pageLoadCommon($("#payPeopleList"), Fa)) : (bU = !0, Ia = 1, $("#memberPage_dl").html(""), Ha(), pageLoadCommon($("#memberPage"), Ha))
	}
	function Ja(a) {
		$.ajax({
			type: "POST",
			url: "/live/topic/kickOut.htm",
			data: a,
			success: function(c) {
				"200" == c.statusCode ? ("Y" == a.status ? ($(".people-manage[attr-userid='" + a.userId + "']").attr("attr-istichu", "Y"), $(".manage-obj[attr-userid='" + a.userId + "']").find(".paypeople_status1").show(), alertMsg("\u6210\u529f\u628a\u6b64\u4eba\u8e22\u51fa", 1)) : ($(".people-manage[attr-userid='" + a.userId + "']").attr("attr-istichu", "N"), $(".manage-obj[attr-userid='" + a.userId + "']").find(".paypeople_status1").hide(), alertMsg("\u6210\u529f\u53d6\u6d88\u8e22\u51fa", 1)), setTimeout(function() {
					window.location.reload(!0)
				}, 1E3)) : alertMsg(c.msg, 1)
			}
		})
	}
	function nb() {
		v && (v = !1, $(".page_loading_box").hide(), $.ajax({
			type: "POST",
			url: "/live/getAllTopic.htm",
			data: {
				liveId: liveId,
				page: w,
				pageSize: O
			},
			success: function(a) {
				$(".page_loading_box").hide();
				if ("200" == a.state.code) {
					a = a.data;
					var c = template("tpl-item-list", {
						data: a
					});
					1 == w ? ($(".DatasListBox").html(c), pageLoadCommon($("#loadPage"), nb, 100)) : $(".DatasListBox").append(c);
					1 == w && 1 > a.length ? $(".none_record").show() : (a.length < O ? $("#loadNone").show() : v = !0, w++)
				} else v = !0, alertMsg(a.msg, 1)
			}
		}))
	}
	function ob() {
		v && (v = !1, $(".page_loading_box").hide(), $.ajax({
			type: "POST",
			url: "/live/topic/getHistoryGuest.htm",
			data: {
				liveId: liveId,
				topicId: topicId,
				page: w,
				pageSize: O
			},
			success: function(a) {
				$(".page_loading_box").hide();
				if ("200" == a.state.code) {
					a = a.data;
					var c = template("tpl-item-list", {
						data: a
					});
					1 == w ? $("#history-people-box").html(c) : $("#history-people-box").append(c);
					1 == w && 1 > a.length ? ($(".none_record").show(), $(".history-t2").hide()) : (a.length < O ? $("#loadNone").show() : ($(".historyLoadMore").show(), v = !0), w++)
				} else v = !0, alertMsg(a.state.msg, 1)
			}
		}))
	}
	$(document).on("click", ".mine-subscribe", function() {
		var a = $(this);
		window._qla && _qla("click", {
			name: $(this).attr("attr-name"),
			business_id: "${userPo.id}",
			business_type: "${userPo.name?html}",
			region: "mine-subscribe"
		});
		setTimeout(function() {
			window.location.href = a.attr("attr-href")
		}, 500)
	});
	$(document).on("click", ".btn_switch", function() {
		$(this).toggleClass("swon")
	});
	0 < $(".pushPicBox").length && (localStorage.getItem("readpic") != $(".pushPicBox").attr("attr-id") && qlSlBoxShow(".pushPicBox"), $(document).on("click", ".pushPicBox .qlMT_close2", function() {
		localStorage.setItem("readpic", $(this).parents(".pushPicBox").attr("attr-id"))
	}));
	/live\/\d+\.htm/.test(location.href) && b(window.isShowQl, window.liveId);
	if (0 < $(".word_scroll").length && $(".word_scroll p").width() > $(".word_scroll a").width()) {
		var J = 0;
		setInterval(h, 20)
	}
	var j = !0,
		ab = 2;
	0 < $("#QLLiveRoom").length && pageLoadCommon($("#QLLiveRoom"), q);
	var B, pb;
	$(document).on("click", "#qliveList .topic-settings, #NqChannelList .topic-settings, #topic_list_new .topic-settings", function() {
		isSingleBuy = $(this).parents(".topic-btnbar").data("status");
		pb = $(this).parents(".topic-btnbar").data("type");
		window.topicId = $(this).parents(".topic-btnbar").data("topicid");
		$("#topicMenu .setSingleBuy").data("isSingleBuy", isSingleBuy);
		isSetFree = 0 < $(this).parents("dd").find(".topic-type-freelisten").length;
		isTopicFree = "public" == $(this).parents(".topic-btnbar").data("type") || "encrypt" == $(this).parents(".topic-btnbar").data("type");
		console.log($(this).parents(".topic-btnbar").data("money"));
		isTopicFree ? $("#topicMenu").data("thisTopicFree", "Y") : ($("#topicMenu").data("thisTopicMoney", $(this).parents(".topic-btnbar").data("money")), $("#topicMenu").data("thisTopicFree", "N"));
		"Y" === isSingleBuy && "charge" == pb ? ($(".btn_switch_setSingleBuy").addClass("swon"), $(".btn_switch_setFree").removeClass("swon"), $(".setSingleBuy").show(), $(".setFree").hide()) : isSetFree ? ($(".btn_switch_setFree").addClass("swon"), $(".btn_switch_setSingleBuy").removeClass("swon"), $(".setFree").show(), $(".setSingleBuy").hide()) : isTopicFree ? ($(".btn_switch_setFree").removeClass("swon"), $(".btn_switch_setSingleBuy").removeClass("swon"), $(".setFree").show(), $(".setSingleBuy").hide()) : ($(".btn_switch_setFree").removeClass("swon"), $(".btn_switch_setSingleBuy").removeClass("swon"), $(".setSingleBuy").show(), $(".setFree").show());
		var a = $("#topicMenu").data("chargetype"),
			c = $("#topicMenu").data("chargeconfigs");
		"absolutely" == a && "0" == c && ($(".setSingleBuy").hide(), $(".setFree").hide());
		a = $(this).parents(".topic-btnbar").data("topicid");
		$("#topicMenu").data("theTopicId", a);
		$("#topicMenu").data("thisTopicId", $(this).attr("attr-topicId"));
		B = $(this);
		B.hasClass("begin") ? $("#topicMenu").addClass("isBegin") : $("#topicMenu").removeClass("isBegin");
		0 < B.parents("dd").find(".topic-type-freelisten").length ? $(".btn_switch_setFree").addClass("swon") : $(".btn_switch_setFree").removeClass("swon");
		var a = $(this).attr("attr-status"),
			c = $(this).attr("attr-type"),
			f = $(this).attr("attr-isrelay");
		$(".changeLiveType").attr("attr-status", a);
		$(".changeLiveType").attr("attr-type", c);
		$(".setRelay").attr("attr-type", c);
		"Y" === f ? ($(".moveTopic").hide(), $(".StopRelay").show(), $(".setRelay").hide()) : ($(".setRelay").show(), $(".StopRelay").hide(), $(".moveTopic").show());
		"public" !== c && "encrypt" !== c || "Y" === f ? $(".changeLiveType").hide() : $(".changeLiveType").show();
		showBottomBox("#topicMenu")
	});
	$(document).on("click", ".setRelay", function() {
		var a = $(this).attr("attr-type"),
			c = $("#topicMenu").data("chargetype") || "";
		0 < $(".btn_switch_setSingleBuy.swon").length || 0 < $(".btn_switch_setFree.swon").length || "public" == a || "encrypt" == a || "" == c ? (a = $("#topicMenu").data("thisTopicId"), window.location.href = "/relay/setup.htm?topicId=" + a) : $(document).popBox({
			topContent: "\u8f6c\u64ad\u8bbe\u7f6e",
			boxType: "",
			boxContent: "\u8be5\u8bdd\u9898\u9700\u8981\u5148\u8bbe\u7f6e\u4ef7\u683c\uff0c\u652f\u6301\u5355\u8282\u8d2d\u4e70\u540e\uff0c\u624d\u53ef\u4ee5\u4e0a\u67b6\u5230\u8f6c\u64ad\u5e02\u573a\uff0c\u70b9\u51fb\u201c\u64cd\u4f5c\u201d\u5373\u53ef\u8bbe\u7f6e\uff0c\u5feb\u53bb\u8bbe\u7f6e\u5427~",
			btnType: "cancel",
			cancelName: "\u77e5\u9053\u4e86",
			textAlign: "center"
		})
	});
	$(document).on("click", ".StopRelay", function() {
		var a = $("#topicMenu").data("thisTopicId");
		$(document).popBox({
			boxType: "\u201csuccess",
			boxContent: "\u53d6\u6d88\u8f6c\u64ad\u5c06\u4e0d\u518d\u7ee7\u7eed\u540c\u6b65\u76f4\u64ad\u8bdd\u9898\u5185\u5bb9\uff0c\u786e\u5b9a\u8981\u53d6\u6d88\u5417\uff1f",
			btnType: "both",
			confirmName: "\u786e\u5b9a",
			cancelName: "\u53d6\u6d88",
			confirmFunction: function() {
				$.ajax({
					url: "/relay/cancelRelay.htm",
					type: "POST",
					data: {
						topicId: a
					},
					success: function(a) {
						200 === a.statusCode ? (alertMsg("\u53d6\u6d88\u6210\u529f\uff01"), refreshPage(), hideBottomBox("#topicMenu")) : alertMsg(a.msg);
						$(".loadingBox").hide()
					},
					error: function(a) {
						a && a.state && a.state.msg && alertMsg(a.state.msg);
						$(".loadingBox").hide()
					}
				})
			},
			cancelFunction: function() {}
		})
	});
	$(document).on("click", ".channelIncludeList .topic-settings,#channelListDl .topic-settings, .channel_settings", function() {
		var a = $(this).parents(".channel_item"),
			c = a.data("topstate");
		a.find(".desc h2").text();
		"Y" === c ? ($("#channel-options li.icon_return").show(), $("#channel-options li.icon_backToTop").hide(), $("#channel-options").attr("attr-topstate", "Y")) : ($("#channel-options li.icon_return").hide(), $("#channel-options li.icon_backToTop").show(), $("#channel-options").attr("attr-topstate", "N"));
		$(".channel-on-option").removeClass("channel-on-option");
		$(this).parents("dd.webkitBox").addClass("channel-on-option");
		showBottomBox("#channel-options")
	});
	$(document).on("click", "#channel-options .icon_backToTop,#channel-options .icon_return", function() {
		var a = $(".channel-on-option"),
			c = a.data("channel-id") || activeChannel.id,
			f;
		f = "Y" != $(this).parents("#channel-options").attr("attr-topstate") ? "Y" : "N";
		$(".loadingBox").show();
		$.ajax({
			url: "/live/channel/updateTop.htm",
			type: "POST",
			data: {
				channelId: c,
				topState: f,
				tagId: window.hasChannelTypes ? window.activeChannelTypes.id : 0
			},
			success: function(c) {
				200 === c.state.code ? (alertMsg(c.state.msg), window.location.reload(), refreshPage(), "Y" === f ? (a.data("topstate", "Y"), c = a.siblings("dd").first(), c !== a && c.before(a)) : (a.data("topstate", "N"), reloadByTimeStampInstant()), hideBottomBox("#channel-options")) : alertMsg(c.state.msg);
				$(".loadingBox").hide()
			},
			error: function(a) {
				$(".loadingBox").hide()
			}
		})
	});
	$(document).on("click", ".delTopic", function() {
		var a = $("#topicMenu").data("thisTopicId") || activeTopic.id,
			c = B.parents("dd"),
			f = c.parents("#qliveList");
		$(document).popBox({
			topContent: "\u5220\u9664\u8bdd\u9898",
			textAlign: "left",
			boxContent: "1.\u5220\u9664\u540e\u8bdd\u9898\u5c06\u4e0d\u80fd\u6062\u590d\u3002<br/>2.\u8bdd\u9898\u4e2d\u82e5\u6709\u5f85\u7ed3\u7b97\u91d1\u989d\uff0c\u5c06\u65e0\u6cd5\u63d0\u73b0\u3002",
			btnType: "both",
			confirmFunction: function() {
				$(".loadingBox").show();
				$.ajax({
					type: "POST",
					url: "/live/topic/topicMg.htm",
					data: {
						topicId: a,
						type: "delete"
					},
					success: function(a) {
						$(".loadingBox").hide();
						"200" == a.statusCode && (c.remove(), hideBottomBox(), 0 >= f.find("dd").length && window.location.reload(!0));
						$(document).minTipsBox({
							tipsContent: a.msg,
							tipsTime: 1
						})
					},
					error: function(a) {
						$(document).minTipsBox({
							tipsContent: a.msg,
							tipsTime: 1
						});
						$(".loadingBox").hide()
					}
				})
			}
		})
	});
	$(document).on("click", ".moveout", function() {
		"Y" == $("#topicMenu").data("thisTopicFree") ? $(document).popBox({
			boxContent: "\u662f\u5426\u5c06\u6b64\u8bdd\u9898\u79fb\u51fa\u7cfb\u5217\u8bfe\uff1f",
			btnType: "both",
			confirmFunction: function() {
				$(".loadingBox").show();
				d(0)
			}
		}) : ($("#setOutMoneyBox").find("#out-charge").val(Number($("#topicMenu").data("thisTopicMoney") / 100).toFixed(2)), qlSlBoxShow("#setOutMoneyBox"))
	});
	$("#setOutMoneyBox .tlbtn_confirm").on("click", function() {
		var a = $("#setOutMoneyBox").find("#out-charge").val();
		validLegal("money", "\u79fb\u51fa\u4ef7\u683c", a, 5E4, 1) && d(Number(100 * a).toFixed(0))
	});
	$("#setOutMoneyBox .icon_cross").on("click", function() {
		$("#setOutMoneyBox").find("#out-charge").val("").focus()
	});
	$("#switchSingleBuyBox .icon_cross").on("click", function() {
		$("#switchSingleBuyBox").find("#sCharge_input").val("").focus()
	});
	var o = !0;
	$(document).on("click", ".stopTopic", function() {
		var a = $("#topicMenu").data("thisTopicId");
		$(document).popBox({
			topContent: "\u7ed3\u675f\u76f4\u64ad",
			textAlign: "left",
			boxContent: "1.\u7ed3\u675f\u76f4\u64ad\u540e\uff0c\u8bb2\u5e08\u5609\u5bbe\u5c06\u4e0d\u80fd\u7ee7\u7eed\u53d1\u8a00\u3002<br/>2.\u7ed3\u675f\u672c\u6b21\u76f4\u64ad\uff0c\u7528\u6237\u5c06\u4ece\u5934\u5f00\u59cb\u56de\u987e\u3002<br/>3.\u82e5\u5728\u8bdd\u9898\u5f00\u64ad\u524d\u7ed3\u675f\u76f4\u64ad\uff0c\u5c06\u5bfc\u81f4\u8be5\u8bdd\u9898\u95e8\u7968\u6536\u76ca\u65e0\u6cd5\u63d0\u73b0\u3002",
			btnType: "both",
			confirmFunction: function() {
				if (o) o = !1;
				else return !1;
				$(".loadingBox").show();
				$.ajax({
					type: "POST",
					url: "/live/topic/topicMg.htm",
					data: {
						topicId: a,
						type: "endTopic"
					},
					success: function(a) {
						$(".loadingBox").hide();
						"200" == a.statusCode && (hideBottomBox(), window.location.reload(!0));
						$(document).minTipsBox({
							tipsContent: a.msg,
							tipsTime: 1
						})
					},
					error: function(a) {
						$(document).minTipsBox({
							tipsContent: a.msg,
							tipsTime: 1
						});
						$(".loadingBox").hide()
					}
				})
			}
		})
	});
	$(".pushTopic").click(function() {
		function a(a) {
			$.ajax({
				type: "GET",
				url: "/live/topic/feedPushNum.htm",
				data: {
					topicId: a
				},
				success: function(a) {
					if ("200" == a.statusCode) {
						var c = $(".pushBox .push-to-timeline");
						0 < a.data.leftFeedPushNum ? (c.show(), c.addClass("checked")) : (c.hide(), c.removeClass("checked"))
					}
					qlSlBoxShow(".pushBox")
				},
				error: function(a) {
					alertMsg(a.state.msg)
				}
			})
		}
		var c = $("#topicMenu").data("thisTopicId");
		$(".pushBox").data("thistopicid", c);
		$.ajax({
			type: "POST",
			url: "/api/wechat/live/pushNum",
			data: {
				topicId: c,
				liveId: liveId
			},
			success: function(b) {
				b = JSON.parse(b);
				0 === b.state.code && ($(".push_top .num var").html(b.data.todayPushNum), $(".push_span_2 .max-num").html(b.data.pushMaxNum), a(c))
			},
			error: function(a) {
				alertMsg(a.state.msg)
			}
		})
	});
	$(".moveTopic").click(function() {
		1 > $(".moveTopicChannelBox li").length ? (S(function() {
			$(".channel_list_box li").eq(0).addClass("qlbga_on");
			qlSlBoxShow(".moveTopicChannelBox")
		}), pageLoadCommon($(".channel_list_box"), S)) : qlSlBoxShow(".moveTopicChannelBox")
	});
	$(".changeLiveType").click(function() {
		var a = $(this).attr("attr-status"),
			c = $(this).attr("attr-type");
		"ended" !== a || "public" !== c && "encrypt" !== c ? alertMsg("\u76f4\u64ad\u7ed3\u675f\u540e\u624d\u80fd\u5207\u6362\u76f4\u64ad\u7c7b\u578b") : qlSlBoxShow(".changeLiveTypeBox")
	});
	var s = !0,
		bb = 1,
		Qb = 10;
	$(document).on("click", ".channel_list_box li", function() {
		$(this).addClass("qlbga_on").siblings().removeClass("qlbga_on")
	});
	$(".moveTopicChannelBox .tlbtn_confirm").click(function() {
		0 < $("li.qlbga_on").length ? C() : alertMsg("\u8bf7\u9009\u62e9\u7cfb\u5217\u8bfe")
	});
	var T = !0,
		P = !0;
	$(".btn_switch_setFree").click(function() {
		var a = $("#topicMenu").data("thisTopicFree");
		if (P) {
			P = !1;
			var c = "N",
				b = $("#topicMenu").data("thisTopicId");
			$(this).hasClass("swon") || (c = "Y");
			$(".loadingBox").show();
			$.ajax({
				type: "POST",
				url: "/live/topic/switch/" + b + ".htm",
				data: {
					status: c,
					topicId: b
				},
				success: function(f) {
					$(document).minTipsBox({
						tipsContent: f.msg,
						tipsTime: 1
					});
					"200" == f.statusCode ? ($(".btn_switch_setFree").toggleClass("swon"), "Y" == c ? ($(".topic-settings[attr-topicId='" + b + "']").parents("dd").find(".channel-topic-pic .topic-type-bar").append('<i class="topic-type-freelisten">\u8bd5\u542c</i>'), $(".btn_switch_setSingleBuy").removeClass("swon"), $.when($(".setSingleBuy").hide()).then(function() {
						$(".loadingBox").hide()
					})) : ($(".topic-settings[attr-topicId='" + b + "']").parents("dd").find(".channel-topic-pic .topic-type-freelisten").remove(), $(".btn_switch_setSingleBuy").removeClass("swon"), "Y" != a && $.when($(".setSingleBuy").show()).then(function() {
						$(".loadingBox").hide()
					}), $(".loadingBox").hide()), P = !0) : (P = !0, $(".loadingBox").hide())
				},
				error: function(a) {
					P = !0;
					$(".loadingBox").hide();
					$(document).minTipsBox({
						tipsContent: a.msg,
						tipsTime: 1
					})
				}
			})
		}
	});
	var D = !1,
		x = "";
	0 < $(".upload_live_logo").length && new imgUpload($(".upload_live_logo"), {
		folder: "liveLogo",
		onComplete: function(a) {
			"" != x ? ($("#live_logo").attr("src", x), x = "") : 0 >= $("#live_logo").length ? (a = '<img id="live_logo" src="' + a + '@300h_300w_1e_1c_2o" />', $(".upload_live_logo").append(a)) : $("#live_logo").attr("src", a + "@300h_300w_1e_1c_2o");
			$(".uploadStatus2").show();
			$(".uploadStatus1").hide();
			$(".marker").hide()
		},
		onChange: function() {
			$(".uploadStatus1").show();
			$(".uploadStatus2").hide();
			for ($(".marker").show(); 1 == D;) D = !1, $(".uploadStatus1 .uploadCancel").html("\u53d6\u6d88")
		},
		onError: function() {
			$(".uploadStatus1").show();
			$(".uploadStatus2").hide();
			$(".marker").show()
		}
	});
	$(document).on("click", ".uploadCancel", function() {
		D = !0;
		x = $("#live_logo").attr("src");
		$(".uploadStatus1").show();
		$(".uploadStatus2").hide();
		$(".uploadStatus1 .uploadCancel").html("\u53d6\u6d88\u4e2d")
	});
	$(document).on("click", ".createLiveSubmit", function() {
		var a = "https://img.qlchat.com/qlLive/liveCommon/normalLogo.png",
			c = $("#live_name").val(),
			b = $("#live_introduce").val();
		validLegal("text", "\u76f4\u64ad\u540d\u79f0", c, 30) && validLegal("text", "\u76f4\u64ad\u4ecb\u7ecd", b, 200) && ($(".loadingBox").show(), 0 < $("#live_logo").length && (a = $("#live_logo").attr("src").replace(/(@)\w*/, "")), K(a, c, b, "", ""))
	});
	var bd = !0,
		D = !1,
		x = "";
	0 < $(".change_live_logo").length && new imgUpload($(".change_live_logo"), {
		folder: "liveLogo",
		onComplete: function(a) {
			"" != x ? ($(".change_live_logo img").attr("src", x), x = "") : $(".change_live_logo img").attr("src", a + "@200h_200w_1e_1c_2o");
			$(".uploadStatus2").show();
			$(".uploadStatus1").hide();
			$(".marker").hide()
		},
		onChange: function() {
			$(".uploadStatus1").show();
			$(".uploadStatus2").hide();
			for ($(".marker").show(); 1 == D;) D = !1, $(".uploadStatus1 .uploadCancel").html("\u53d6\u6d88")
		},
		onError: function() {
			$(".uploadStatus1").show();
			$(".uploadStatus2").hide();
			$(".marker").show()
		}
	});
	$(document).on("click", ".changeFLogoBox .uploadCancel", function() {
		D = !0;
		x = $("#live_logo").attr("src");
		$(".uploadStatus1").show();
		$(".uploadStatus2").hide();
		$(".uploadStatus1 .uploadCancel").html("\u53d6\u6d88\u4e2d")
	});
	// $(".changeLiveLogo").click(function() {
	// 	$(".change_live_logo img").attr("src", $(".changeLiveLogo img").attr("src"));
	// 	qlSlBoxShow(".changeFLogoBox")
	// });
	$(".changeFLogoBox .tlbtn_confirm").click(function() {
		var a = $(".change_live_logo img").attr("src").replace(/(@)\w*/, ""),
			c = E();
		$.ajax({
			type: "POST",
			url: "/live/entity/modify.htm",
			data: {
				liveId: c,
				type: "logo",
				value: a
			},
			success: function(c) {
				"200" == c.statusCode ? ($(document).minTipsBox({
					tipsContent: "\u4fdd\u5b58\u6210\u529f",
					tipsTime: 1
				}), $(".changeLiveLogo img").attr("src", a + "@200h_200w_1e_1c_2o"), $(".changeFLogoBox").hide()) : $(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				})
			},
			error: function() {}
		})
	});
	var be = !1,
		fa = "";
	0 < $(".change_personal_logo").length && new imgUpload($(".change_personal_logo"), {
		folder: "userHeadImg",
		onComplete: function(a) {
			"" != fa ? ($(".change_personal_logo img").attr("src", fa), fa = "") : $(".change_personal_logo img").attr("src", a + "@132h_132w_1e_1c_2o");
			$(".uploadStatus2").show();
			$(".uploadStatus1,.marker").hide()
		},
		onChange: function() {
			$(".uploadStatus1,.marker").show();
			for ($(".uploadStatus2").hide(); 1 == be;) be = !1, $(".uploadStatus1 .uploadCancel").html("\u53d6\u6d88")
		},
		onError: function() {
			$(".uploadStatus1,.marker").show();
			$(".uploadStatus2").hide()
		}
	});
	$(document).on("click", ".changeUserHeadBox .uploadCancel", function() {
		be = !0;
		fa = $("#live_logo").attr("src");
		$(".uploadStatus1").show();
		$(".uploadStatus2").hide();
		$(".uploadStatus1 .uploadCancel").html("\u53d6\u6d88\u4e2d")
	});
	$(".changePersonalLogo").click(function() {
		$(".change_personal_logo img").attr("src", $(".changePersonalLogo img").attr("src"));
		qlSlBoxShow(".changeUserHeadBox")
	});
	var U = !0;
	$(document).on("click", ".changeUserHeadBox .tlbtn_confirm", function() {
		u()
	});
	$(".changePersonalName").click(function() {
		$(".userNameValue").val($(".changePersonalName p").text());
		qlSlBoxShow(".changeUserNameBox")
	});
	$(document).on("click", ".changeUserNameBox .tlbtn_confirm", function() {
		u()
	});
	$(".logout").on("click", function(a) {
		$(document).popBox({
			boxType: "",
			boxContent: "\u662f\u5426\u786e\u5b9a\u8981\u9000\u51fa\u5f53\u524d\u5e10\u53f7\uff1f",
			btnType: "both",
			confirmName: "\u9000\u51fa",
			cancelName: "\u53d6\u6d88",
			textAlign: "center",
			confirmFunction: function() {
				isAndroid() || isiOS() ? window.location.href = "/loginOut.htm?url=" + window.location.origin + encodeURIComponent("/wechat/page/wx-login/") : window.location.href = "/loginOut.htm"
			},
			cancelFunction: function() {}
		})
	});
	$(".changePromote").click(function() {
		$(".changePromoteBox").show()
	});
	0 < $("#promote_switch").length && $(document).switchBtn({
		obj: "#promote_switch",
		switchType: "complex",
		functionafter: "Y",
		isOn: $(".changePromote").attr("attr-ison"),
		onFunction: function() {
			V("Y")
		},
		offFunction: function() {
			V("N")
		}
	});
	$(".changeLiveName").click(function() {
		$(".nextliveTalker").val($(".changeLiveName p").text());
		$(".changeFNameBox").show()
	});
	$(".hyroomid").click(function() {
		$(".nexthyroomid").val($(".hyroomid p").text());
		$(".changeHyroomidBox").show()
	});
	$(".hjroomid").click(function() {
		$(".nexthjroomid").val($(".hjroomid p").text());
		$(".changeHjroomidBox").show()
	});
	$(".uid").click(function() {
		$(".nextuid").val($(".uid p").text());
		$(".changeUidBox").show()
	});
	$(".easyid").click(function() {
		$(".nexteasyid").val($(".easyid p").text());
		$(".changeEasyidBox").show()
	});
	$(".status").click(function() {
		$(".nextstatus").val($(".status p").text());
		$(".changeStatusBox").show()
	});
	$(".liveid").click(function() {
		$(".nextliveid").val($(".liveid p").text());
		$(".changeLiveidBox").show()
	});
	$(".tid").click(function() {
		$(".nexttid").val($(".tid p").text());
		$(".changeTidBox").show()
	});
	$(".ssid").click(function() {
		$(".nextssid").val($(".ssid p").text());
		$(".changeSsidBox").show()
	});
	$(".sid").click(function() {
		$(".nextsid").val($(".sid p").text());
		$(".changeSidBox").show()
	});
	$(".changeFNameBox .tlbtn_confirm").click(function() {
		var a = $(".nextliveTalker").val(),
			c = E();
		validLegal("text", "\u76f4\u64ad\u95f4\u540d\u5b57", a, 32) && $.ajax({
			type: "POST",
			url: "/live/entity/modify.htm",
			data: {
				liveId: c,
				type: "name",
				value: a
			},
			success: function(c) {
				"200" == c.statusCode ? ($(document).minTipsBox({
					tipsContent: "\u4fdd\u5b58\u6210\u529f",
					tipsTime: 1
				}), refreshPage(), $(".changeLiveName p").text(a), $(".changeFNameBox").hide()) : $(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				})
			},
			error: function() {}
		})
	});
	var bf = !0;
	$(".changeFIntroduceBox .tlbtn_confirm").click(function() {
		var a = $(".changeFIntroduceBox .reply_textarea").val();
		if (validLegal("text", "\u76f4\u64ad\u7b80\u4ecb", a, 200) && bf) {
			bf = !1;
			var c = E();
			$.ajax({
				type: "POST",
				url: "/live/entity/modify.htm",
				data: {
					liveId: c,
					type: "introduce",
					value: a
				},
				success: function(c) {
					bf = !0;
					"200" == c.statusCode ? ($(document).minTipsBox({
						tipsContent: "\u4fdd\u5b58\u6210\u529f",
						tipsTime: 1
					}), refreshPage(), $(".LiveIntroduce").val(a), $(".changeLiveIntroduce p").text(a), $(".changeFIntroduceBox").hide()) : $(document).minTipsBox({
						tipsContent: c.msg,
						tipsTime: 1
					})
				},
				error: function() {
					bf = !0
				}
			})
		}
	});
	$(".live_code").click(function() {
		"" == $(".forumQRBox .logo_QRcode img").attr("src") && $(".forumQRBox .logo_QRcode img").attr("src", "http://qr.topscan.com/api.php?text=" + $(".liveLink").text());
		$(".forumQRBox").show()
	});
	$(document).on("click", ".live_list dd", function(a) {
		if ($(this).hasClass("live_more")) return !0;
		"wt_btn_manage" != a.target.className && "forum_name" != a.target.className && (window.location.href = $(this).find(".forum_name").attr("href"))
	});
	$(".please_button").on("click", function() {
		var a = $(".please_text").val();
		validLegal("text", "\u9080\u8bf7\u7801", a) && $.ajax({
			type: "POST",
			url: "/live/entity/validCode.htm",
			data: {
				inviteCode: a
			},
			success: function(a) {
				"200" == a.statusCode ? ($(document).minTipsBox({
					tipsContent: "\u7533\u8bf7\u6210\u529f",
					tipsTime: 1
				}), refreshPage(), window.location.href = "/live/entity/addIndex.htm?restime==" + (new Date).getTime()) : $(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			},
			error: function() {}
		})
	});
	$(document).on("click", ".coupon_stlbtn,.appSendCoupon", function(a) {
		if ("app" == getCookie("caller")) {
			a.preventDefault();
			a = $(this).hasClass("appSendCoupon") ? "\u70b9\u51fb\u5373\u53ef\u9886\u53d6\u4f18\u60e0\u7801\uff0c\u5148\u5230\u5148\u5f97\u3002\u94fe\u63a5\u6c38\u4e45\u6709\u6548" : "\u70b9\u51fb\u5373\u53ef\u9886\u53d6\u4f18\u60e0\u7801\u3002\u94fe\u63a5\u6c38\u4e45\u6709\u6548";
			var c = $("#topicName").val(),
				b = window.location.origin + $(this).attr("app-share-link");
			console.log(b);
			appJump("shareFriend", b, c, a, "https://img.qlchat.com/qlLive/liveCommon/couponsend_ico.png")
		}
	});
	var bg = !0;
	$(document).on("click", ".people_set", function() {
		"topicCreater" == $(this).attr("attr-del") ? ($(".livebox_foot").hide(), $(".livebox_body").addClass("not_del")) : ($(".livebox_foot").show(), $(".livebox_body").removeClass("not_del"));
		var a = $(this).parents(".people_info_box dd"),
			c = a.index();
		$(".parterSetBox .nowname").html(a.find(".people_name").html());
		a = a.find(".people_pic").attr("attr-id");
		$(".parterSetBox .nowname").attr("attr-id", a);
		$(".parterSetBox .nowname").attr("attr-index", c);
		$(".parterSetBox").show()
	}).on("click", ".history_set", function() {
		var a = $(this),
			c = a.parents("dd").find(".people_name").html();
		$(document).popBox({
			boxContent: "\u8bbe\u7f6e\u4e3a\u672c\u8bdd\u9898\u7684\u5609\u5bbe\uff0c\u76f4\u63a5\u8bbf\u95ee\u8bdd\u9898\u5373\u53ef\u53d1\u8a00\u3002<br>\u786e\u5b9a\u5c06<var class='pop-guestname elli'>" + c + "</var>\u8bbe\u7f6e\u4e3a\u5609\u5bbe\uff1f",
			btnType: "both",
			confirmFunction: function() {
				xa(a)
			}
		})
	});
	$(document).on("click", ".parterSetBox .livebox_body li", function() {
		$(".people_title").eq($(".parterSetBox .nowname").attr("attr-index")).html($(this).attr("attr-title"));
		$(this).parents(".parterSetBox").hide();
		var a = $(".parterSetBox .nowname").attr("attr-id"),
			c = $(this).attr("class"),
			b = $(this).attr("attr-title");
		0 < $(".parterSetBox .livebox_body.not_del").length && (c = "topicCreater");
		$.ajax({
			type: "POST",
			url: "/live/invite/topicModify.htm",
			data: {
				topicInviteId: a,
				role: c,
				liveId: liveId,
				title: b,
				topicId: topicId
			},
			success: function(a) {
				var c = a.state;
				"200" == c.code ? $(document).minTipsBox({
					tipsContent: a.data,
					tipsTime: 1
				}) : $(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				})
			},
			error: function() {}
		})
	});
	$(document).on("click", ".parterSetBox .delepeople", function() {
		var a = $(this).parents(".livebox"),
			c = a.find(".nowname").attr("attr-id"),
			b = a.find(".nowname").attr("attr-index"),
			k = a.find(".nowname").text();
		a.hide();
		$(document).popBox({
			boxContent: "\u786e\u5b9a\u8981\u5220\u9664" + k + "?",
			btnType: "both",
			confirmFunction: function() {
				$.ajax({
					type: "POST",
					url: "/live/invite/topicDelete.htm",
					data: {
						topicInviteId: c,
						liveId: liveId
					},
					success: function(a) {
						"200" == a.statusCode ? ($(".people_info_box dd").eq(b).remove(), $(document).minTipsBox({
							tipsContent: "\u5220\u9664\u6210\u529f",
							tipsTime: 1
						}), window.location.reload(!0)) : $(document).minTipsBox({
							tipsContent: a.msg,
							tipsTime: 1
						})
					},
					error: function() {}
				})
			}
		})
	});
	$(".adm_delete").click(function() {
		var a = $(this).parents(".people_info_box dd"),
			c = $(this).attr("attr-id");
		$(".admDeleteBox .nowname").html(a.find(".people_name").html());
		$(".admDeleteBox .gene_confirm").attr("attr-id", c);
		$(".admDeleteBox .gene_confirm").attr("attr-index", $(this).index());
		$(".admDeleteBox").show()
	});
	$(document).on("click", ".admDeleteBox .gene_confirm", function() {
		var a = $(this).attr("attr-id"),
			c = $(this).attr("attr-index");
		$.ajax({
			type: "POST",
			url: "/live/invite/mgrDelete.htm",
			data: {
				userRefId: a,
				liveId: liveId
			},
			success: function(a) {
				"200" == a.statusCode ? ($(".people_info_box dd").eq(c).remove(), $(".admDeleteBox").hide(), $(document).minTipsBox({
					tipsContent: "\u5220\u9664\u6210\u529f",
					tipsTime: 1
				}), window.location.reload(!0)) : $(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			},
			error: function() {}
		})
	});
	$(".live_nexttopic_list .setTalk").on("click", function() {
		$(".LiveNextTalkBox .nextliveTalker").val($(".setTalk p").text());
		qlSlBoxShow(".LiveNextTalkBox")
	});
	$(document).on("click", ".LiveNextTalkBox .tlbtn_confirm", function() {
		var a = $(".LiveNextTalkBox .nextliveTalker").val();
		validLegal("text", "\u76f4\u64ad\u8bdd\u9898", a, 40) && ($(".setTalk p").text(a), $(".LiveNextTalkBox").hide())
	});
	$(".live_nexttopic_list .setTalker").on("click", function() {
		$(".LiveNextTalkerBox .nextliveTalker").val($(".setTalker p").text());
		$(".LiveNextTalkerBox").show()
	});
	$(document).on("click", ".LiveNextTalkerBox .gene_confirm", function() {
		var a = $(".LiveNextTalkerBox .nextliveTalker").val();
		validLegal("text", "\u4e3b\u8bb2\u4eba\u540d\u79f0", a, 32) && ($(".setTalker p").text(a), $(".LiveNextTalkerBox").hide())
	});
	$(".live_nexttopic_list .setNote").on("click", function() {
		$(".LiveNextNoteBox .reply_textarea").val($(".setNote p").text());
		$(".LiveNextNoteBox").show()
	});
	$(document).on("click", ".LiveNextNoteBox .gene_confirm", function() {
		var a = $(".LiveNextNoteBox .reply_textarea").val();
		validLegal("text", "\u76f4\u64ad\u5907\u6ce8", a, 200) && ($(".setNote p").text(a), $(".LiveNextNoteBox").hide())
	});
	var bh = !0;
	$(".setNewLiveTopic").on("click", function() {
		var a = $(".form_datetime").attr("data-date"),
			c = symbolFilter($(".setTalker p").text()),
			b = symbolFilter($(".setTalk p").text()),
			k = symbolFilter($(".setNote p").text()),
			g = $(".setTalk").attr("attr-id");
		validLegal("text", "\u76f4\u64ad\u8bdd\u9898", b, 40) && validLegal("text", "\u4e3b\u8bb2\u4eba\u540d\u79f0", c, 32) && validLegal("text", "\u76f4\u64ad\u5907\u6ce8", k, 200) && validLegal("text", "\u5f00\u59cb\u65f6\u95f4", a) && bh && (bh = !1, $.ajax({
			type: "POST",
			url: "/live/topic/add.htm",
			data: {
				topicId: g,
				speaker: c,
				planTime: a,
				remark: k,
				topic: b
			},
			success: function(a) {
				"200" == a.statusCode ? ($(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				}), window.location.href = "/live/" + a.liveTopicView.liveId + "/" + a.liveTopicView.id + ".htm") : $(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				});
				bh = !0
			},
			error: function() {
				bh = !0
			}
		}))
	});
	var bi = !0;
	$(".roomListTab a").click(function() {
		$(this).addClass("on").siblings().removeClass("on");
		$(".live_list." + $(this).attr("name") + "List").addClass("on").siblings(".live_list").removeClass("on");
		"myLiveRoom" == $(this).attr("name") ? X = "N" : "attendLiveRoom" == $(this).attr("name") && (X = "Y", bi && (bi = !1, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/entity/myLiveList.htm", {
			isFollow: "Y",
			page: 1,
			pageSize: 10
		}, function(a, c, b) {
			$(".page_loading_box").hide();
			0 < $("#pageLoadBox dd").length ? $(".loadStBox").before($("#pageLoadBox").html()) : $("#followNone").show();
			$("#pageLoadBox").html("");
			y = !0
		})))
	});
	var bj = $(".livelistBox").height(),
		W = 1,
		cb = 1,
		X = "N";
	0 < $("#attendLiveRoomList").length && (X = "Y");
	$(".livelistBox").scroll(function() {
		distanceScrollCount = $(this)[0].scrollHeight;
		distanceScroll = $(this)[0].scrollTop;
		2 > distanceScrollCount - distanceScroll - bj && L()
	});
	var y = !0;
	$(".liveLink").click(function(a) {
		a.preventDefault()
	});
	var m = !0;
	if (0 < $("#myIncomeList").length) {
		var bk = 2;
		pageLoadCommon($("#myIncomeList"), function() {
			m && (m = !1, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/reward/getReward.htm", {
				dataType: "topic",
				userType: "user",
				page: bk,
				pageSize: 6
			}, function(a, c, b) {
				$(".page_loading_box").hide();
				0 < $("#pageLoadBox li").length ? ($(".myMoneyDetailList").append($("#pageLoadBox").html()), m = !0, $("#pageLoadBox").html(""), bk++) : $("#loadNone").show()
			}))
		})
	}
	if (0 < $("#liveIncomeList").length) {
		var bl = function() {
				var a = $(".income_detail_title li.on").attr("attr-type");
				if (m && (!tb && "topic" === a || !ub && "channel" === a)) {
					m = !1;
					var c = "topic" === a ? $b++ : vb++;
					$("#" + a + "_income_content .page_loading_box").show();
					$("#pageLoadBox").load("/live/reward/getReward.htm", {
						dataType: a,
						liveId: liveId,
						userType: "live",
						page: c,
						pageSize: 6
					}, function(b, k, g) {
						$("#" + a + "_income_content .page_loading_box").hide();
						0 < $("#pageLoadBox ul").length ? ($("#" + a + "_income_content .income_list").append($("#pageLoadBox").html()), $("#pageLoadBox").html("")) : ("topic" === a ? tb = !0 : ub = !0, 1 < c ? $("#" + a + "_income_content .loadNone").show() : $("#" + a + "_income_content .money_nonelist").show());
						m = !0
					})
				}
			},
			$b = 2,
			vb = 1,
			xb = 1,
			tb = !1,
			ub = !1;
		$(document).on("click", ".income_detail_title li", function() {
			$(".income_detail_content").find("#" + $(this).attr("attr-type") + "_income_content").addClass("on").siblings("dd").removeClass("on");
			$(this).addClass("on").siblings("li").removeClass("on");
			m = !0;
			1 == vb && bl();
			"vip" === $(this).attr("attr-type") && 1 == xb && (xb++, $.ajax({
				type: "POST",
				url: "/live/reward/vip/income.htm",
				data: {
					liveId: liveId
				},
				success: function(a) {
					if ("200" == a.state.code) {
						var c = [];
						c.push(a.data);
						console.log(c);
						a = template("tpl-item-list", {
							dataview: c[0]
						});
						$("#vip_income_content .income_list").append(a)
					}
				}
			}))
		});
		1 > $("#topic_income_content .income_list ul").length && $("#topic_income_content .money_nonelist").show();
		pageLoadCommon($(".income_detail_content dd"), bl)
	}
	if (0 < $("#vipIcomeDetailBox").length) {
		var bm = function() {
				m && (m = !1, $(".page_loading_box").show(), $.ajax({
					type: "POST",
					url: "/live/reward/vip/income/record.htm",
					data: JSON.stringify({
						data: {
							id: liveId
						},
						page: {
							page: yb,
							size: 20
						}
					}),
					contentType: "application/json",
					success: function(a) {
						"200" == a.state.code && ($(".page_loading_box").hide(), console.log(a.data), dataview = a.data, 0 < dataview.length ? (a = template("tpl-item-list", {
							dataview: dataview
						}), $(".vip_list").append(a), 20 > dataview.length ? $("#loadNone").show() : (yb++, m = !0)) : $(".this_nonelist").show())
					}
				}))
			},
			yb = 1,
			m = !0;
		bm();
		pageLoadCommon($("#vipIcomeDetailBox"), bm)
	}
	if (0 < $("#takeIncomeList").length) {
		var bn = 2;
		pageLoadCommon($("#takeIncomeList"), function() {
			m && (m = !1, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/reward/getWithDraw.htm", {
				liveId: liveId,
				userType: "live",
				page: bn,
				pageSize: 6
			}, function(a, c, b) {
				$(".page_loading_box").hide();
				0 < $("#pageLoadBox li").length ? ($(".liveMoneyDetailList").append($("#pageLoadBox").html()), m = !0, $("#pageLoadBox").html(""), bn++) : $("#loadNone").show()
			}))
		})
	}
	if (0 < $("#zanPeopleList").length) {
		var bo = function() {
				m && (m = !1, $("#zanPeopleList .page_loading_box").show(), $("#zanPeopleList #loadNone").hide(), $("#pageLoadBox").load("/live/reward/findRewardDetailArc.htm", {
					topicId: La,
					topicType: "public",
					page: Ma,
					pageSize: 20
				}, function(a, c, b) {
					$("#zanPeopleList .page_loading_box").hide();
					0 < $("#zanPeopleList #pageLoadBox dd").length ? ($("#zanPeopleList .fans_list").append($("#zanPeopleList #pageLoadBox").html()), m = !0, $("#zanPeopleList #pageLoadBox").html(""), $("#zanPeopleList .money_nonelist").hide(), Ma++) : 1 < Ma ? $("#zanPeopleList #loadNone").show() : $("#zanPeopleList .money_nonelist").show()
				}))
			},
			Ma = 1,
			La = $("#zanPeopleList").attr("attr-topicid");
		bo();
		pageLoadCommon($("#zanPeopleList"), bo)
	}
	var bp = !0;
	if (0 < $("#ticketDetailList").length) {
		var bq = function() {
				bp && (bp = !1, $("#ticketDetailList .page_loading_box").show(), $("#ticketDetailList #pageLoadBox").load("/live/reward/findRewardDetailArc.htm", {
					topicId: La,
					topicType: "charge",
					page: G,
					pageSize: 20
				}, function(a, c, b) {
					$("#ticketDetailList .page_loading_box").hide();
					0 < $("#ticketDetailList #pageLoadBox dd").length ? ($("#ticketDetailList .fans_list").append($("#ticketDetailList #pageLoadBox").html()), bp = !0, $("#ticketDetailList #pageLoadBox").html(""), $("#ticketDetailList .money_nonelist").hide(), G++) : 1 < G ? $("#ticketDetailList #loadNone").show() : $("#ticketDetailList .money_nonelist").show()
				}))
			},
			G = 1,
			La = $("#ticketDetailList").attr("attr-topicid");
		bq();
		pageLoadCommon($("#ticketDetailList"), bq)
	}
	0 < $("#fansListBox").length && (G = 2, pageLoadCommon($("#fansListBox"), function() {
		m && (m = !1, $("#loadNone").hide(), $("#pageLoadBox").load("/live/invite/lastNewFollowList/getLastNewFollowList.htm", {
			liveId: liveId,
			page: G,
			pageSize: 20
		}, function(a, c, b) {
			$(".page_loading_box").hide();
			0 < $("#pageLoadBox dd").length ? ($("#fansListBox .fans_list").append($("#pageLoadBox").html()), m = !0, $("#pageLoadBox").html(""), G++) : $("#loadNone").show()
		}))
	}));
	if (0 < $("#channelIcomeDetailBox").length) {
		var br = function() {
				m && (m = !1, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/reward/channelIncomeDetailArc.htm", {
					channelId: $("#channelIcomeDetailBox").attr("attr-channelid"),
					pageNo: Oa,
					pageSize: 20
				}, function(a, c, b) {
					$(".page_loading_box").hide();
					0 < $("#pageLoadBox dd").length ? ($("#channelIcomeDetailBox .channel_list").append($("#pageLoadBox").html()), m = !0, $("#pageLoadBox").html(""), Oa++) : 1 < Oa ? $("#loadNone").show() : $(".this_nonelist").show()
				}))
			},
			Oa = 1;
		br();
		pageLoadCommon($("#channelIcomeDetailBox"), br)
	}
	var r = !0;
	$(document).on("click", ".takeMoney", function() {
		var a = $(".timoneyValue").text();
		if (1 > a) return $(document).minTipsBox({
			tipsContent: "\u63d0\u73b0\u91d1\u989d\u4e0d\u80fd\u5c0f\u4e8e1\u5143",
			tipsTime: 1.5
		}), !1;
		2E3 >= a ? M(a, "") : $(".checkNameBox").show()
	});
	$(document).on("click", ".send_again", function() {
		$(".money_detaillist_post").removeClass("on");
		$(this).parents(".money_detaillist_post").addClass("on");
		qlSlBoxShow(".checkNameAgainBox")
	});
	$(document).on("click", ".checkNameBox .tlbtn_confirm", function() {
		var a = $(".timoneyValue").text(),
			c = $(".check_name_input").val();
		c && 0 < c.length ? M(a, c) : alertMsg("\u8bf7\u8f93\u5165\u59d3\u540d")
	});
	$(document).on("click", ".checkNameAgainBox .tlbtn_confirm", function() {
		var a = $("#takeIncomeList").attr("attr-operid"),
			c = $(".money_detaillist_post.on").attr("attr-id"),
			b = $(".check_name_input").val();
		b && 0 < b.length ? za(a, c, b) : alertMsg("\u8bf7\u8f93\u5165\u59d3\u540d")
	});
	r = !0;
	$(document).on("click", ".qlbmi_livebox_close", function() {
		$(this).parents(".livebox").hide()
	});
	$(document).on("click", ".redbagfuncbox2_close", function() {
		db("REWARDGUID", "redbag2")
	});
	$(".rewardpercent").click(function() {
		$(".rewardpercent_list").show()
	});
	$(".rewardpercent_list").click(function(a) {
		"percent_li" != a.target.className && $(".rewardpercent_list").hide()
	});
	$(document).on("click", ".percent_li", function() {
		$(".rewardpercent var").html() != $(this).find("var").text() + "%" && ($(".reward_open").addClass("on").text("\u786e\u8ba4"), $(".reward_close").removeClass("on"));
		$(".rewardpercent var").html($(this).find("var").text() + "%");
		$(".rewardpercent_list").hide()
	});
	0 < $(".introduction_pic").length && new imgUpload($(".introduction_pic"), {
		folder: "introductionPic",
		onComplete: function(a) {
			$(".introduction_pic img").show().attr("src", a + "@150h_490w_1e_1c_2o_0l");
			$(".loadingBox").hide();
			$(".introduction_pic").prepend('<span class="qlbmi_close_btn"></span>')
		},
		onChange: function() {
			$(".loadingBox").show()
		},
		onError: function() {
			$(".loadingBox").hide()
		}
	});
	var bs = [];
	$(".rewardPrice").click(function() {
		bs = $(".rePrice").data("price").split(";");
		for (i = 0; i < bs.length; i++) $(".rewardPrice_ul input").eq(i).val(bs[i]);
		$(".rewardPrice_box").show()
	});
	$(".blktlbtn_rewardPrice").click(function() {
		var a = $(".rewardPrice_ul input"),
			c = !1;
		newPrice = "";
		a.each(function() {
			newPrice += $(this).val() + ";";
			c = isNumberValid($(this).val(), 2, 1E3, "\u8d5e\u8d4f\u91d1\u989d");
			if (!c) return !1
		});
		c && (newPrice = newPrice.substring(0, newPrice.length - 1), $(".rewardPrice p").data("price", newPrice), $(".rewardPrice p").text(newPrice.replace(/;/gi, "\u3001")), $(".rewardPrice_box").hide())
	});
	$(document).on("click", ".qlbmi_close_btn", function(a) {
		var c = this;
		$(document).popBox({
			boxContent: "\u5220\u9664\u56fe\u7247\u540e\u70b9\u51fb\u786e\u8ba4\u624d\u4f1a\u751f\u6548",
			btnType: "both",
			confirmFunction: function() {
				$(".introduction_pic img").attr("src", "").hide();
				$(c).remove()
			}
		})
	});
	$(document).on("click", ".reward_open", function() {
		$(this);
		p("Y", function() {
			refreshPage();
			$(document).minTipsBox({
				tipsContent: "\u8bbe\u7f6e\u6210\u529f",
				tipsTime: 1
			});
			window.location.reload(!0)
		})
	});
	$(document).on("click", ".btn_switch_opLukMny", function() {
		var a = $(this),
			c = a.hasClass("swon") ? "N" : "Y";
		"Y" == c ? (a.toggleClass("swon"), $(".rewardpercent").data("fristpercent", "open"), $(".introduction_settings").toggleClass("on")) : p(c, function() {
			a.toggleClass("swon");
			$(".introduction_settings").toggleClass("on");
			$(document).minTipsBox({
				tipsContent: "\u8bbe\u7f6e\u6210\u529f",
				tipsTime: 1
			})
		}, !0)
	});
	var Y = !0;
	$(".live_nexttopic_set .setTalk").on("click", function() {
		$(".TopicNextTalkBox .nexttopicTalk").val($(".setTalk p").text());
		qlSlBoxShow(".TopicNextTalkBox")
	});
	$(document).on("click", ".TopicNextTalkBox .tlbtn_confirm", function() {
		var a = $(".TopicNextTalkBox .nexttopicTalk").val();
		validLegal("text", "\u76f4\u64ad\u8bdd\u9898", a, 40) && ($(".setTalk p").text(a), $(".TopicNextTalkBox").hide())
	}).on("click", ".backone", function() {
		history.back()
	});
	var z = !0;
	$(document).on("click", ".password_set dt span", function() {
		$(this).addClass("on").siblings().removeClass("on");
		$(this).parents(".password_set").find(".password_tabbox div[name='" + $(this).attr("name") + "']").addClass("on").siblings().removeClass("on");
		$(".fixedCodeValue").focus()
	});
	$(document).on("click", ".setNewLiveNext", function() {
		var a = $("#topic-title-edit").val().trim(),
			c = $(".topicDateTime").val();
		if (validLegal("text", "\u76f4\u64ad\u8bdd\u9898", a, 40) && validLegal("text", "\u5f00\u59cb\u65f6\u95f4", c)) if ("" != channelId) {
			var b = $(".setTalk").attr("attr-id"),
				k = Math.ceil(8 * Math.random(.1, 1)),
				g = $("#live-type-list .icon_checked.on").attr("data-style");
			0 == k && (k = 0);
			e({
				liveId: window.liveId,
				topicId: b,
				channelId: window.channelId,
				startTime: c,
				topic: a,
				type: "charge",
				money: 99900,
				backgroundUrl: "https://img.qlchat.com/qlLive/topicHeaderPic/thp-" + k + ".jpg",
				style: g
			})
		} else $(".topic_create_two").show(), $(".topic_create_one").hide(), history.pushState("create-step-two", null)
	});
	0 < $(".setNewLiveNext").length && (window.onpopstate = function(a) {
		switch (a.state) {
		case null:
			$(".topic_create_two").hide();
			$(".topic_create_one").show();
			break;
		case "create-step-two":
			$(".topic_create_two").show(), $(".topic_create_one").hide()
		}
	});
	$(".auto_height").keydown(function() {
		var a = $(this);
		setTimeout(function() {
			a.css("height", "auto").css("padding", "0 1rem");
			a.css("height", a[0].scrollHeight + "px")
		}, 0)
	});
	$(document).on("click", ".setNewTopicBtn", function() {
		var a = $(".topicDateTime").val(),
			c = $("#topic-title-edit").val().trim(),
			b = $(".setTalk").attr("attr-id"),
			k = $(".password_type.on").attr("attr-type"),
			g = "",
			d = "",
			l = "",
			p = "Y",
			t = "N",
			h = "",
			m = !0;
		if (validLegal("text", "\u76f4\u64ad\u8bdd\u9898", c, 40) && validLegal("text", "\u5f00\u59cb\u65f6\u95f4", a)) {
			if ("public" != k || $(".authSwitch").hasClass("swon") || (p = "N"), "encrypt" == k ? (g = $(".password_random_tab.on .fixedCodeValue").val(), 0 < $(".passwordqr_choose .on img").length && (d = $(".passwordqr_choose .on img").attr("src").replace(/(@)\w*/, "") || ""), m = validLegal("password", "\u5bc6\u7801", g, 12)) : "charge" == k && (l = $(".TicketPriceValue").val().trim(), h = $(".autoSubscribeValue").val().trim(), (m = validLegal("money", "\u7968\u4ef7", l, 5E4, 1)) && $(".autoSubscribeSwitch").hasClass("swon") && (t = "Y", m = isNumberValid(h, 1, 80, "\u81ea\u52a8\u5206\u9500\u5206\u6210\u6bd4\u4f8b"))), m) {
				var l = (100 * Number(l)).toFixed(0),
					m = Math.ceil(8 * Math.random(.1, 1)),
					q = $("#live-type-list .icon_checked.on").attr("data-style");
				e({
					liveId: window.liveId,
					topicId: b,
					startTime: a,
					topic: c,
					type: k,
					password: g,
					qcodeUrl: d,
					money: l,
					backgroundUrl: "https://img.qlchat.com/qlLive/topicHeaderPic/thp-" + m + ".jpg",
					isPush: "off",
					isNeedAuth: p,
					isAutoshareOpen: t,
					autoSharePercent: h,
					style: q
				})
			}
		} else $(".topic_create_two").hide(), $(".topic_create_one").show()
	});
	$(document).on("click", ".password_tabbox .autoSubscribeSwitch", function() {
		$(".autoSubscribe").toggleClass("show")
	});
	$(document).on("click", "#channel-marketing-auto-share .autoSubscribeSwitch", function() {
		$(".autoSubscribe").toggleClass("show")
	});
	$(document).on("click", ".passset_confirm", function() {
		var a = $(".topicpassword_value").attr("attr-id"),
			c = "";
		0 < $(".passwordqr_choose .on img").length && (c = $(".passwordqr_choose .on img").attr("src").replace(/(@)\w*/, ""));
		var b = $(".topicpassword_value").val();
		validLegal("password", "\u5bc6\u7801", b, 12) && z && (z = !1, $.ajax({
			type: "POST",
			url: "/live/topic/addorupdate.htm",
			data: {
				liveId: liveId,
				topicId: a,
				type: "encrypt",
				password: b,
				qcodeUrl: c
			},
			success: function(a) {
				"200" == a.statusCode ? ($(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				}), window.location.href = "/topic/" + a.liveTopicView.id + ".htm") : ($(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				}), z = !0)
			},
			error: function(a) {
				z = !0;
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		}))
	});
	$(".live_nexttopic_set .topicName").on("click", function() {
		$(".setTopicNameBox .nexttopicTalk").val($(".topicName p").text());
		qlSlBoxShow(".setTopicNameBox")
	});
	$(document).on("click", ".setTopicNameBox .tlbtn_confirm", function() {
		var a = $(".setTopicNameBox .nexttopicTalk").val();
		if (40 < a.length) return $(document).minTipsBox({
			tipsContent: "\u8bdd\u9898\u540d\u79f0\u4e0d\u80fd\u8d85\u8fc740\u4e2a\u5b57",
			tipsTime: 1
		}), !1;
		"" != a.trim() ? $(".topicName p").text(a) : $(".topicName p").text("");
		$(".setTopicNameBox").hide()
	});
	$(".live_nexttopic_set .setGuestName").on("click", function() {
		$(".setGuestNameBox .nexttopicTalk").val($(".setGuestName p").text());
		qlSlBoxShow(".setGuestNameBox")
	});
	$(document).on("click", ".setGuestNameBox .tlbtn_confirm", function() {
		var a = $(".setGuestNameBox .nexttopicTalk").val();
		if (32 < a.length) return $(document).minTipsBox({
			tipsContent: "\u5609\u5bbe\u540d\u79f0\u4e0d\u80fd\u8d85\u8fc732\u4e2a\u5b57",
			tipsTime: 1
		}), !1;
		"" != a.trim() ? $(".setGuestName p").text(a) : $(".setGuestName p").text("");
		$(".setGuestNameBox").hide()
	});
	$(".live_nexttopic_set .setGuestIntro").on("click", function() {
		$(".setGuestIntroBox .nexttopicTalk").val($(".setGuestIntro p").text());
		qlSlBoxShow(".setGuestIntroBox")
	});
	$(document).on("click", ".setGuestIntroBox .tlbtn_confirm", function() {
		var a = $(".setGuestIntroBox .nexttopicTalk").val() || "";
		if (200 < a.length) return $(document).minTipsBox({
			tipsContent: "\u5609\u5bbe\u4ecb\u7ecd\u4e0d\u80fd\u8d85\u8fc7200\u4e2a\u5b57",
			tipsTime: 1
		}), !1;
		"" != a.trim() ? $(".setGuestIntro p").text(a) : $(".setGuestIntro p").text("");
		$(".setGuestIntroBox").hide()
	});
	$(".live_nexttopic_set .setTicketPrice").on("click", function() {
		$(".setTicketPriceBox .ticketInput").val($(".setTicketPrice p").text());
		qlSlBoxShow(".setTicketPriceBox")
	});
	$(document).on("click", ".setTicketPriceBox .tlbtn_confirm", function() {
		var a = $(".setTicketPriceBox .ticketInput").val() || "";
		if (!validLegal("money", "\u7968\u4ef7", a, 5E4, 1)) return !1;
		$(".setTicketPrice p").text(Number(a).toFixed(2));
		$(".setTicketPriceBox").hide()
	});
	$(".live_nexttopic_set .setTicketPassword").on("click", function() {
		$(".setTicketPasswordBox .passwordInput").val($(".setTicketPassword p").text());
		qlSlBoxShow(".setTicketPasswordBox")
	});
	$(document).on("click", ".setTicketPasswordBox .tlbtn_confirm", function() {
		var a = $(".setTicketPasswordBox .passwordInput").val() || "";
		validLegal("password", "\u5bc6\u7801", a.trim(), 12) && ($(".setTicketPassword p").text(a), $(".setTicketPasswordBox").hide())
	});
	$(".live_nexttopic_set .setTalkShort").on("click", function() {
		$(".setTalkShortBox .nexttopicTalk").val($(".setTalkShort p").text());
		qlSlBoxShow(".setTalkShortBox")
	});
	$(document).on("click", ".setTalkShortBox .tlbtn_confirm", function() {
		var a = $(".setTalkShortBox .nexttopicTalk").val() || "";
		if (2E3 < a.length) return $(document).minTipsBox({
			tipsContent: "\u8bdd\u9898\u6982\u8981\u4e0d\u80fd\u8d85\u8fc72000\u4e2a\u5b57",
			tipsTime: 1
		}), !1;
		"" != a.trim() ? $(".setTalkShort p").text(a) : $(".setTalkShort p").text("");
		$(".setTalkShortBox").hide()
	});
	var bt = !0;
	$(document).on("click", ".setTopicTicketSubmit", function() {
		var a = $(".topicName p").text(),
			c = $(".setGuestName p").text(),
			b = $(".setGuestIntro p").text(),
			k = $(".setTalkShort p").text(),
			g = $(".setTicketPrice p").text(),
			e = $(".setTicketPassword p").text(),
			d = $(".setTime").val(),
			l = $("#liveTicketBox").attr("attr-id"),
			p = $(".ticketHeaderSet").attr("attr-src"),
			h = !0,
			t = !1,
			m = !1;
		"charge" == liveType ? h = validLegal("money", "\u7968\u4ef7", g, 5E4, 1) : "encrypt" == liveType && (h = validLegal("password", "\u5bc6\u7801", e, 12));
		t = validLegal("text", "\u8bdd\u9898\u540d\u79f0", a, 40);
		m = d ? validLegal("text", "\u8bdd\u9898\u65f6\u95f4", d) : !0;
		g = (100 * Number(g)).toFixed(0);
		h && t && m && bt && (bt = !1, $.ajax({
			type: "POST",
			url: "/live/topic/addorupdate.htm",
			data: {
				liveId: liveId,
				topicId: l,
				topic: a,
				startTime: d,
				money: g,
				password: e,
				speaker: c,
				remark: k,
				guestIntr: b,
				backgroundUrl: p,
				operate: "updateDetail"
			},
			success: function(a) {
				"200" == a.statusCode ? ($(document).minTipsBox({
					tipsContent: "\u4fdd\u5b58\u6210\u529f",
					tipsTime: 1
				}), window.location.reload(!0)) : ($(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				}), bt = !0)
			},
			error: function(a) {
				bt = !0;
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		}))
	});
	$(".setfocus").click(function() {
		$(".focusQr1Box").show()
	});
	$(document).on("click", ".payed_btn", function() {
		window.location.href = $(this).attr("attr-href") + "?isGuide=Y&_=" + (new Date).getTime() + "&shareKey=" + shareKey
	});
	$(document).on("click", ".freeinto_btn", function() {
		var a = $(this);
		joinTopic(shareKey, topicId, function() {
			window.location.href = a.attr("attr-href") + "?isGuide=Y&_=" + (new Date).getTime() + "&shareKey=" + shareKey
		})
	});
	0 < $(".serveQrBox").length && getFocusQrFunction(".enterFocusQr", "110", window.topicId, window.liveId, "", function() {
		iMPay && !isFollowedThird && "N" === isFree && qlSlBoxShow(".serveQrBox")
	}, window.channelId);
	$(document).on("click", ".payQrBox", function(a) {
		"payQrPic" != a.target.className && $(this).hide()
	});
	var A;
	$(document).on("click", ".focusQr2Box", function(a) {
		"focusPic" != a.target.className && $(".focusQr2Box").hide()
	});
	$(".stlbtn_follow").click(function() {
		t(Rb)
	});
	0 < $("#qr_img").length && getFocusQrFunction(".focusfunc_btn", 103, "", liveId, "", function() {
		$(".focusfunc_btn").show()
	});
	$(".btn-cancel-follow").on("click", function(a) {
		a.preventDefault();
		a.stopPropagation();
		var c = $(this);
		c.hasClass("canceled") ? followLive("no", "", function() {
			c.removeClass("canceled icon_plus").text("\u5df2\u5173\u6ce8")
		}, c.closest(".dd_1").children(".forum_info").attr("data-id")) : $(document).popBox({
			boxType: "",
			boxContent: "\u786e\u8ba4\u4e0d\u518d\u5173\u6ce8\u6b64\u76f4\u64ad\u95f4\uff1f",
			btnType: "both",
			confirmName: "\u786e\u5b9a",
			cancelName: "\u53d6\u6d88",
			textAlign: "center",
			confirmFunction: function() {
				followLive("yes", "", function() {
					c.addClass("canceled icon_plus").text("\u5173\u6ce8")
				}, c.closest(".dd_1").children(".forum_info").attr("data-id"))
			},
			cancelFunction: function() {}
		})
	});
	$(document).on("click", ".set_remind", function() {
		var a = $(this);
		a.hasClass("reminded") ? updateAlert("N", liveId, function() {
			a.html("<i class='icon_ring2'></i> \u5f00\u542f\u901a\u77e5");
			a.removeClass("reminded")
		}) : "true" == isFocus ? updateAlert("Y", liveId, function() {
			a.html("<i class='icon_ring2'></i> \u5df2\u5f00\u542f\u901a\u77e5");
			a.addClass("reminded");
			Ba()
		}) : followLive("no", "", function() {
			a.html("<i class='icon_ring2'></i> \u5df2\u5f00\u542f\u901a\u77e5");
			$(".followers").text(Number($(".followers").text()) + 1);
			a.addClass("reminded");
			Ba()
		})
	});
	$(document).on("click", ".focusfuncbox_close", function() {
		qlSlBoxShow(".funcFTips")
	}).on("click", ".funcFTips .tlbtn_cancel", function() {
		db("FOCUSGUID", "focus")
	}).on("click", ".funcFTips .tlbtn_confirm", function() {
		$(".funcFTips").hide()
	});
	$(document).on("click", ".password_state", function() {
		$(".passUseBox").show()
	}).on("click", ".connectqr", function() {
		$(this).toggleClass("on").siblings(".otherqr").removeClass("on")
	}).on("click", ".otherqr", function() {
		0 < $("#otherqr_logo").length && $(this).toggleClass("on").siblings(".connectqr").removeClass("on")
	});
	0 < $(".upload_topic_otherqr").length && new imgUpload($(".upload_topic_otherqr"), {
		folder: "followQRCode",
		onComplete: function(a) {
			0 >= $("#otherqr_logo").length ? (a = '<img id="otherqr_logo" src="' + a + '@300h_300w_1e_1c_2o" />', $(".upload_topic_otherqr").append(a)) : $("#otherqr_logo").attr("src", a + "@300h_300w_1e_1c_2o");
			$(".otherqr").addClass("on").siblings(".connectqr").removeClass("on");
			$(".loadingBox").hide()
		},
		onChange: function() {
			$(".loadingBox").show()
		},
		onError: function() {
			$(".loadingBox").hide()
		}
	});
	0 < $(".upload_topic_changeqr").length && new imgUpload($(".upload_topic_changeqr"), {
		folder: "followQRCode",
		onComplete: function(a) {
			0 >= $("#changeqr_logo").length ? (a = '<img id="changeqr_logo" src="' + a + '@300h_300w_1e_1c_2o" />', $(".upload_topic_otherqr").append(a)) : $("#changeqr_logo").attr("src", a + "@300h_300w_1e_1c_2o");
			$(".loadingBox").hide()
		},
		onChange: function() {
			$(".loadingBox").show()
		},
		onError: function() {
			$(".loadingBox").hide()
		}
	});
	var Z = !0,
		Qa = "no";
	$(".onetoone_agreement .icon_checked").click(function() {
		var a = $(this);
		a.hasClass("checked") ? (a.removeClass("checked"), Qa = "yes") : (a.addClass("checked"), Qa = "no")
	});
	var H = !0,
		Q = "";
	try {
		sessionStorage.getItem("messageId") && (Q = sessionStorage.getItem("messageId"), codeCountdown($(".s_get_msg"), $(".btn_get_msg"), 60, "messageTime"))
	} catch (a) {}
	$(document).on("click", ".btn_get_msg", function() {
		$(".ofVeriCode").focus();
		var a = $(".onetoonePhone").val().trim();
		H && validLegal("phoneNum", "\u624b\u673a\u53f7", a) && (a = Number(a), $.ajax({
			type: "POST",
			url: "/live/mobile/sendCode.htm",
			data: {
				mobile: a
			},
			success: function(a) {
				H = !0;
				"200" == a.state.code ? (Q = a.data.messageId, sessionStorage.setItem("messageId", Q), sessionStorage.setItem("messageTime", (new Date).getTime()), codeCountdown($(".s_get_msg"), $(".btn_get_msg"), 60, "messageTime")) : $(document).minTipsBox({
					tipsContent: a.state.msg,
					tipsTime: 1
				})
			},
			error: function(a) {
				a = result;
				H = !0;
				$(document).minTipsBox({
					tipsContent: a.state.msg,
					tipsTime: 1
				})
			}
		}))
	});
	$(document).on("click", ".onetoone_confirm", function() {
		var a = $(this).attr("attr-id"),
			c = $(".onetooneWx").val().trim(),
			b = $(".onetoonePhone").val().trim(),
			k = $(".ofVeriCode").val().trim(),
			g = $(".btn_qlradio.on").attr("name");
		liveId = "100000081018489";
		if ("" == Q) return alertMsg("\u8bf7\u83b7\u53d6\u9a8c\u8bc1\u7801"), !1;
		if (6 != k.length) return alertMsg("\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u9a8c\u8bc1\u7801"), !1;
		if (0 >= $(".btn_qlradio.on").length) return alertMsg("\u8bf7\u9009\u62e9\u8eab\u4efd\u540e\u518d\u63d0\u4ea4"), !1;
		H && validLegal("phoneNum", "\u624b\u673a\u53f7", b) && validLegal("money", "\u9a8c\u8bc1\u7801", k) && validLegal("wxAccount", "\u5fae\u4fe1\u53f7", c) && $.ajax({
			type: "POST",
			url: "/live/mobile/validCode.htm",
			data: {
				code: k,
				messageId: Q
			},
			success: function(f) {
				H = !0;
				"200" == f.state.code ? (sessionStorage.removeItem("messageId"), followLive(Qa, "100000081018489", function() {
					"" == a ? K("https://img.qlchat.com/qlLive/liveCommon/normalLogo.png", "", "", c, b, g) : Sb(a, c, b, g)
				})) : $(document).minTipsBox({
					tipsContent: f.state.msg,
					tipsTime: 1
				})
			},
			error: function(a) {
				H = !0;
				$(document).minTipsBox({
					tipsContent: a.state.msg,
					tipsTime: 1
				})
			}
		})
	});
	var bu = !0;
	if (0 < $("#shutUpList").length) {
		var bv = 1;
		pageLoadCommon($("#shutUpList"), function() {
			bu && (bu = !1, bv++, $(".page_loading_box").show(), $("#pageLoadBox").load("/live/entity/blackList/getBlackList.htm", {
				liveId: liveId,
				page: bv,
				pageSize: 20
			}, function(a, c, b) {
				$(".page_loading_box").hide();
				0 < $("#pageLoadBox li").length ? ($(".shutupListBox").append($("#pageLoadBox").html()), bu = !0, $("#pageLoadBox").html("")) : $("#loadNone").show()
			}))
		})
	}
	$(document).on("click", ".shutup_btn a", function() {
		var a = $(this),
			c = $(this).attr("attr-liveid"),
			b = $(this).attr("attr-userid");
		$(document).popBox({
			boxContent: "\u786e\u5b9a\u89e3\u9664\u8be5\u7528\u6237\u7981\u8a00\u5417\uff1f",
			btnType: "both",
			confirmFunction: function() {
				$(".loadingBox").show();
				$.ajax({
					type: "POST",
					url: "/live/entity/updateBlackList.htm",
					data: {
						liveId: c,
						userId: b,
						isEnable: "N",
						type: "banned"
					},
					success: function(c) {
						"200" == c.statusCode ? (a.parents("li").remove(), 1 > $("#shutUpList .shutupListBox li").length && $("#shutUpList").append('<div class="money_nonelist"><div class="none_record none_pic6"><span class="none_tip">\u6682\u65e0\u7981\u8a00\u7528\u6237</span></div></div>')) : $(document).minTipsBox({
							tipsContent: c.msg,
							tipsTime: 1
						});
						$(".loadingBox").hide()
					}
				})
			}
		})
	});
	$(document).on("click", ".menu_expland, .live_share", function() {
		isiOS() || isAndroid() ? $(document).popBox({
			boxContent: '<ul class="menu_expland_ul"><li>1.\u70b9\u51fb\u9875\u9762\u53f3\u4e0a\u89d2 <i class="menu_expland_qlbgi1"></i></li><li>2.\u9009\u62e9 <i class="menu_expland_qlbgi2"></i><b>\u53d1\u9001\u7ed9\u597d\u53cb</b> \u6216 <i class="menu_expland_qlbgi3"></i><b>\u670b\u53cb\u5708</b></li></ul>',
			btnType: "cancel",
			cancelName: "\u5173\u95ed"
		}) : $(document).popBox({
			boxContent: '<ul class="menu_expland_ul"><li>1.\u5fae\u4fe1\u5ba2\u6237\u7aef\u6253\u5f00 \u70b9\u51fb\u9875\u9762\u53f3\u4e0a\u89d2 <i class="menu_expland_qlbgi4"></i>\uff0c\u9009\u62e9<b>\u201c\u8f6c\u53d1\u7ed9\u597d\u53cb\u201d</b></li><li>2.\u7528\u6d4f\u89c8\u5668\u7aef\u6253\u5f00<b> \u201c\u590d\u5236\u94fe\u63a5\u201d</b>\u53d1\u9001\u7ed9\u670b\u53cb</li></ul>',
			btnType: "cancel",
			cancelName: "\u5173\u95ed"
		})
	});
	$(document).on("click", ".choose_list dd", function() {
		var a = $(this).attr("attr-id");
		$.ajax({
			type: "POST",
			url: "/live/entity/changeLive.htm",
			data: {
				liveId: a
			},
			success: function(c) {
				"200" == c.statusCode ? ($(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				}), window.location.href = "/live/entity/list.htm?liveId=" + a + "&_=" + (new Date).getTime()) : $(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				})
			}
		})
	});
	$(document).on("click", ".back_a_onetoone", function() {
		$(this).attr("attr-url");
		$(".onetooneqr").attr("src", "//open.weixin.qq.com/qr/code?username=qianliaoKT");
		qlSlBoxShow(".oneToOneQrBox")
	});
	var bw = !0,
		Gb = !0;
	$(document).on("click", ".header_tab_bar span", function() {
		var a = $(this).index();
		$(this).addClass("on").siblings("span").removeClass("on");
		$(".h_tab_box").eq(a).show().siblings(".h_tab_box").hide();
		a = $(this).attr("attr-type");
		"gift" === a && bw ? (bw = !1, bx()) : "doc" === a && Gb && (Gb = !1, bc())
	});
	var bx = function() {
			function a() {
				if (!k || g) return !1;
				e.show();
				g = !0;
				$.ajax({
					url: "/live/gift/topic.htm",
					data: {
						topicId: window.topicId,
						pageNum: b,
						pageSize: 20
					},
					success: function(a) {
						if (200 === a.state.code) {
							var f = a.data.map(function(a) {
								var c = a.userHeaderImgUrl;
								/(img\.qlchat\.com)/.test(c) ? c = c.replace(/@.*/, "") + "@64h_64w_1e_1c_2o" : /(wx\.qlogo\.cn\/mmopen)/.test(c) && (c = c.replace(/(\/(0|132|64|96)$)/, "/64"));
								return '<dd>\t<span class="fans_list_img">\t\t<img src="' + c + '"/>\t</span>\t<span class="fans_list_name">' + a.userName + '</span>\t<span class="fans_list_money">\u652f\u4ed8\u4e86 \uffe5<var>' + a.money / 100 + '</var></span>\t<span class="fans_list_time">' + a.createTime + "</span></dd>"
							});
							c.append($(f.join("")));
							0 === a.data.length && (d.show(), k = !1);
							1 === b && 0 === a.data.length && l.show();
							b++
						}
						e.hide();
						g = !1
					}
				})
			}
			var c = $("#giftList .fans_list");
			c.empty();
			var b = 1,
				k = !0,
				g = !1,
				e = $("#giftList .page_loading_box"),
				d = $("#giftList .tips_1"),
				l = $("#giftList .money_nonelist");
			a();
			pageLoadCommon($("#giftList"), a)
		},
		bc = function() {
			function a() {
				if (!k || g) return !1;
				e.show();
				g = !0;
				$.ajax({
					url: "/doc/api/earnings.htm",
					data: JSON.stringify({
						data: {
							topicId: window.topicId
						},
						page: {
							page: b,
							size: 20
						}
					}),
					method: "POST",
					contentType: "application/json",
					success: function(a) {
						if (200 === a.state.code) {
							var f = a.data.userDocs.map(function(a) {
								return '<li class="file_record_item">\t<span class="portrait"><img src="' + a.icon + '" alt=""></span>\t<section class="content">\t\t<p class="username">' + a.userName + '</p>\t\t<p class="file_name">' + a.name + '</p>\t\t<div class="file_base_info">\t\t\t<span>' + a.createTime.split(" ")[0] + '</span>\t\t\t<span class="pay_text">\u652f\u4ed8 \uffe5' + (a.amount / 100).toFixed(2) + "</span>\t\t</div>\t</section></li>"
							});
							c.append($(f.join("")));
							0 === a.data.userDocs.length && (k = !1, 1 !== b && d.show());
							1 === b && 0 === a.data.userDocs.length && l.show();
							b++;
							e.hide();
							g = !1
						} else 110 === a.state.code ? (e.hide(), g = !1, window.location.href = a.data) : (e.hide(), g = !1)
					}
				})
			}
			var c = $("#docList .fans_list");
			c.empty();
			var b = 1,
				k = !0,
				g = !1,
				e = $("#docList .page_loading_box"),
				d = $("#docList .tips_1"),
				l = $("#docList .money_nonelist");
			a();
			pageLoadCommon($("#docList"), a)
		};
	if (0 < $(".tongji_list").length) {
		var by = function() {
				Sa && (Sa = !1, $("#chargeLiveList .page_loading_box").show(), $("#chargeLiveList #pageLoadBox").load("/live/reward/findTopicByLiveIdArc.htm", {
					liveId: Hb,
					topicType: "charge",
					page: Ta,
					pageSize: Ib
				}, function(a, c, b) {
					$("#chargeLiveList .page_loading_box").hide();
					0 < $("#chargeLiveList #pageLoadBox dd").length ? ($("#chargeLiveList .pay_list").append($("#chargeLiveList #pageLoadBox").html()), Sa = !0, $("#chargeLiveList #pageLoadBox").html(""), Ta++) : 1 < Ta ? $("#chargeLiveList #loadNone").show() : $("#chargeLiveList .money_nonelist").show()
				}))
			},
			Kb = function() {
				Ua && (Ua = !1, $("#lmLiveList .page_loading_box").show(), $("#lmLiveList #pageLoadBox").load("/live/reward/findTopicByLiveIdArc.htm", {
					liveId: Hb,
					topicType: "public",
					page: Va,
					pageSize: Ib
				}, function(a, c, b) {
					$("#lmLiveList .page_loading_box").hide();
					0 < $("#lmLiveList #pageLoadBox dd").length ? ($("#lmLiveList .zan_list").append($("#lmLiveList #pageLoadBox").html()), Ua = !0, $("#lmLiveList #pageLoadBox").html(""), Va++) : 1 < Va ? $("#lmLiveList #loadNone").show() : $("#lmLiveList .money_nonelist").show()
				}))
			},
			Hb = $(".tongji_list").attr("attr-id"),
			Va = 1,
			Ta = 1,
			Ib = 20,
			Ua = !0,
			Sa = !0;
		Kb();
		pageLoadCommon($("#lmLiveList"), Kb);
		by();
		pageLoadCommon($("#chargeLiveList"), by)
	}
	if (0 < $(".first_create_topic").length) {
		try {
			localStorage.getItem("firstCreateTopic") || $(".first_create_topic").show()
		} catch (a) {}
		$(document).on("click", ".first_create_topic", function() {
			$(".first_create_topic").hide();
			try {
				localStorage.setItem("firstCreateTopic", "Y")
			} catch (a) {}
		})
	}
	$(document).on("click", ".qlbmb_newtopic,.new-topic-btn", function(a) {
		a.preventDefault();
		try {
			localStorage.setItem("firstCreateTopic", "Y")
		} catch (c) {}
		beginCountGt10 && "0" == beginCountGt10 ? 0 < $(".realname-y").length ? window.location.href = $(this).attr("href") + "?liveId=" + liveId + "&_=" + (new Date).getTime() : 0 < $(".realname-n").length && $(".realname-n").attr("attr-pop") ? $(".realname-n").click() : window.location.href = $(this).attr("href") + "?liveId=" + liveId + "&_=" + (new Date).getTime() : $(document).popBox({
			boxContent: "\u6b63\u5728\u76f4\u64ad\u7684\u8bdd\u9898\u4e0d\u80fd\u8d85\u8fc750\u4e2a<br>\u8bf7\u7ed3\u675f\u540e\u518d\u65b0\u5efa",
			btnType: "confirm",
			confirmName: "\u77e5\u9053\u4e86"
		})
	}).on("click", ".new-channel-btn", function(a) {
		a.preventDefault();
		var c = $(this);
		if (0 < $(".realname-y").length) window.location.href = c.attr("href");
		else {
			if ($(".realname-n").attr("isLiveIndex") && "true" != isLogIn) return !1;
			lb(liveId, "channel", function(a, b) {
				0 < $(".realname-n").length && b ? $(".realname-n").click() : window.location.href = c.attr("href")
			})
		}
	});
	if (0 < $("#distributeSwitch").length) $(document).on("click", "#distributeSwitch", function() {
		$(this).hasClass("swon") ? $(document).popBox({
			topContent: "\u5173\u95ed\u5206\u4eab\u6392\u884c\u699c",
			boxContent: "\u5173\u95ed\u5206\u4eab\u699c\u540e\uff0c\u76f4\u64ad\u4ecb\u7ecd\u9875\u5c06\u4e0d\u4f1a\u51fa\u73b0\u5206\u4eab\u699c\uff0c\u662f\u5426\u5173\u95ed\uff1f",
			btnType: "tran",
			confirmName: "\u662f",
			cancelName: "\u5426",
			confirmFunction: function() {
				eb("N")
			}
		}) : eb("Y")
	});
	var bz = !0;
	$("#distributePaySwitch");
	1 > $(".qlTimerShow").length && 0 < $("#liveTicketBox").length && (currentTimeMillis < startTime && "ended" != liveStatus ? (timerSecond = startTime - currentTimeMillis, qlStartTimer = setInterval(function() {
		timerSecond -= 1E3;
		var a = parseInt(timerSecond / 864E5),
			c = parseInt(timerSecond / 36E5 - 24 * a),
			b = parseInt(timerSecond / 6E4 - 1440 * a - 60 * c),
			e = parseInt(timerSecond / 1E3 - 86400 * a - 3600 * c - 60 * b);
		$(".qlDays").text(checkTime(a));
		$(".qlHours").text(checkTime(c));
		$(".qlMinutes").text(checkTime(b));
		$(".qlSeconds").text(checkTime(e));
		0 >= timerSecond && clearInterval(qlStartTimer)
	}, 1E3), setTimeout(function() {
		$(".ql_start_box").addClass("qlTimerShow")
	}, 1E3)) : $(".ql_start_box").remove());
	var bA = !0;
	if (0 < $(".thistopicpassword_a").length) $(document).on("keydown", function(a) {
		"13" == a.keyCode && $(".thistopicpassword_a").click()
	});
	$(document).on("click", ".thistopicpassword_a", function() {
		validLegal("text", "\u9a8c\u8bc1\u7801", $(".thistopicpassword").val(), 12) && bA && (bA = !1, $(".loadingBox").show(), $.post("/live/verifyCode.htm", {
			topicId: topicId,
			password: $(".thistopicpassword").val(),
			shareKey: shareKey
		}, function(a) {
			"200" == a.statusCode ? ($(".loadingBox").hide(), $(document).minTipsBox({
				tipsContent: "\u9a8c\u8bc1\u6210\u529f",
				tipsTime: 1
			}), window.location.href = $(".thistopicpassword_a").attr("attr-href") + "?isGuide=Y&_=" + (new Date).getTime() + "&shareKey=" + shareKey, bA = !0) : (bA = !0, $(document).minTipsBox({
				tipsContent: a.msg,
				tipsTime: 1
			}), $(".loadingBox").hide())
		}))
	});
	$(".fromlive_focus").click(function() {
		t(function() {
			fb(function() {
				"\u5df2\u5173\u6ce8" == $(".fromlive_focus").text() && ("1" != isFollowedQL ? getFocusQrFunction(".focusQr3Box", "110", topicId, liveId, "", function() {
					qlSlBoxShow(".focusQr3Box")
				}) : alertMsg("\u5df2\u6210\u529f\u8bbe\u7f6e\u5f00\u64ad\u901a\u77e5"))
			})
		})
	});
	$(document).on("click", ".focusLiveBox .tlbtn_confirm", function() {
		var a = $(this);
		"N" == isFocus && 0 < $(".focusLiveBtn.on").length ? t(function() {
			fb(function() {
				window.location.href = a.attr("attr-href") + "?isGuide=Y&_=" + (new Date).getTime() + "&shareKey=" + shareKey
			})
		}) : window.location.href = a.attr("attr-href") + "?isGuide=Y&_=" + (new Date).getTime() + "&shareKey=" + shareKey
	}).on("click", ".focusLiveBtn", function() {
		$(this).hasClass("on") ? $(".focusLiveBtn").removeClass("on") : $(".focusLiveBtn").addClass("on")
	});
	var bB = !0;
	$(document).on("click", ".couponChannelConfirm", function() {
		var a = $(".couponcode").val().trim();
		if (validLegal("text", "\u4f18\u60e0\u7801", a) && bB) {
			bB = !1;
			var c = "",
				c = "channel" === window.pageType ? "/live/channelCoupon/bindCode.htm" : "vip" === window.pageType ? "/live/vipCoupon/bindCode.htm" : "/live/coupon/bindCode.htm";
			$.ajax({
				type: "POST",
				url: c,
				data: {
					code: a,
					topicId: window.topicId,
					channelId: window.channelId,
					liveId: window.liveId
				},
				success: function(a) {
					if ("200" == a.statusCode) {
						$(document).minTipsBox({
							tipsContent: "\u4f18\u60e0\u7801\u9a8c\u8bc1\u6210\u529f",
							tipsTime: 1
						});
						a = window.location.search.substring(1).split("&");
						for (var c = "", b = 0; b < a.length; b++) {
							var f = a[b].split("=");
							"shareKey" == f[0] && (c = f[1])
						}
						c && "" !== c && void 0 !== c && (c = "shareKey=" + c + "&");
						if ("app" == getCookie("caller")) switch (window.pageType) {
						case "channel":
							window.location.href = "qlchat://dl/live/channel/homepage?channelId=" + channelId;
							break;
						case "vip":
							window.location.href = "qlchat://dl/close";
							break;
						case "topic":
							window.location.href = "qlchat://dl/live/topic/introduce?topicId=" + topicId
						} else a = "channel" === window.pageType ? "/live/channel/channelPage/" + window.channelId + ".htm?" + c + "restime=" + (new Date).getTime() : "vip" === window.pageType ? "/live/whisper/vip.htm?liveId=" + window.liveId : "/topic/" + window.topicId + ".htm?" + c + "restime=" + (new Date).getTime(), window.location.href = a
					} else $(document).minTipsBox({
						tipsContent: a.msg,
						tipsTime: 1
					});
					bB = !0
				},
				error: function() {
					$(document).minTipsBox({
						tipsContent: data.msg,
						tipsTime: 1
					});
					bB = !0
				}
			})
		}
	});
	if (0 < $("#couponList").length) {
		var bC = function() {
				m && (m = !1, $(".page_loading_box").show(), $("#pageLoadBox").load(I, {
					topicId: window.topicId,
					channelId: window.channelId,
					liveId: window.liveId,
					page: Wa,
					pageSize: 6
				}, function(a, c, b) {
					$(".page_loading_box").hide();
					0 < $("#pageLoadBox dd").length ? ($(".coupon_post").append($("#pageLoadBox").html()), $("#pageLoadBox").html(""), Wa++) : 1 >= Wa ? $(".money_nonelist").show() : $("#loadNone").show();
					m = !0
				}))
			},
			Wa = 1,
			I = "";
		"channel" === couponType ? I = "/live/channelCoupon/getCodeList.htm" : "topic" === couponType ? I = "/live/coupon/getCodeList.htm" : "vip" === couponType && (I = "/live/vipCoupon/getCodeList.htm");
		bC();
		pageLoadCommon($("#couponList"), bC);
		"app" === getCookie("caller") && ($("#qlbgbBack").hide(), $("#couponList").css({
			top: 0
		}))
	}
	var bD = !0;
	$(document).on("click", ".createCouponBtn", function() {
		var a = $(".couponMoneyValue p i").text(),
			c = $(".couponTimeValue").attr("attr-time"),
			b = $(".couponNumValue p").text(),
			e = $(".couponRemarkValue p").text(),
			g = "";
		"topic" === couponType ? g = "/live/coupon/addCoupon.htm" : "channel" === couponType ? g = "/live/channelCoupon/addCoupon.htm" : "vip" === couponType && (g = "/live/vipCoupon/addCoupon.htm");
		validLegal("text", "\u6709\u6548\u65f6\u95f4", c) && validLegal("money", "\u4f18\u60e0\u91d1\u989d", a, 5E4, .01) && isNumberValid(b, 1, 500, "\u751f\u6210\u6570") && bD && (bD = !1, a = (100 * Number(a)).toFixed(0), $.ajax({
			type: "POST",
			url: g,
			data: {
				topicId: window.topicId,
				channelId: window.channelId,
				liveId: window.liveId,
				money: a,
				overType: c,
				codeNum: b,
				memo: e
			},
			success: function(a) {
				$(".loadingBox").hide();
				"200" == a.statusCode ? ($(document).minTipsBox({
					tipsContent: "\u751f\u6210\u4f18\u60e0\u7801\u6210\u529f",
					tipsTime: 1
				}), "topic" === couponType ? window.location.href = "/live/coupon/codeList.htm?topicId=" + window.topicId + "&_=" + (new Date).getTime() : "channel" === couponType ? window.location.href = "/live/channelCoupon/codeList.htm?channelId=" + window.channelId + "&_=" + (new Date).getTime() : "vip" === couponType && (window.location.href = "/live/vipCoupon/codeList.htm?liveId=" + window.liveId + "&_=" + (new Date).getTime())) : ($(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				}), bD = !0)
			},
			error: function(a) {
				$(".loadingBox").hide();
				bD = !0;
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		}))
	});
	$(document).on("click", ".couponNumValue", function() {
		$(".setcoupon_input").val($(".couponNumValue p").html());
		qlSlBoxShow(".couponCountBox")
	}).on("click", ".couponTimeValue", function() {
		qlSlBoxShow(".couponTimeBox");
		$(".btn_qlradio[name='" + $(".couponTimeValue").attr("attr-time") + "']").click()
	}).on("click", ".couponMoneyValue", function() {
		$(".setcoupon_money_input").val($(".couponMoneyValue p i").html());
		qlSlBoxShow(".couponMoneyBox")
	}).on("click", ".couponRemarkValue", function() {
		qlSlBoxShow(".couponRemarkBox")
	}).on("click", ".couponCountBox .tlbtn_confirm", function() {
		var a = $(".setcoupon_input").val();
		isNumberValid(a, 1, 500, "\u751f\u6210\u6570") && ($(".couponNumValue p").html(a), $(".couponCountBox").hide())
	}).on("click", ".couponTimeBox .tlbtn_confirm", function() {
		var a = $(".btn_qlradio.on").attr("name");
		$(".couponTimeValue").attr("attr-time", a);
		switch (a) {
		case "forever":
			$(".couponTimeValue p").html("\u6c38\u4e45\u6709\u6548");
			break;
		case "oneDay":
			$(".couponTimeValue p").html("24\u5c0f\u65f6\u5185\u6709\u6548");
			break;
		case "halfAnHour":
			$(".couponTimeValue p").html("30\u5206\u949f\u5185\u6709\u6548")
		}
		$(".couponTimeBox").hide()
	}).on("click", ".couponMoneyBox .tlbtn_confirm", function() {
		var a = $(".setcoupon_money_input").val();
		validLegal("money", "\u4f18\u60e0\u91d1\u989d", a, 5E4, .01) && ($(".couponMoneyValue p").html("\uffe5<i>" + $(".setcoupon_money_input").val() + "</i>"), $(".couponMoneyBox").hide())
	}).on("click", ".couponRemarkBox .tlbtn_confirm", function() {
		var a = $(".setremark_input").val();
		validLegal("text", "\u5907\u6ce8", a, 10, 0) && ($(".couponRemarkValue p").text(a), $(".couponRemarkBox").hide())
	});
	$(document).on("click", ".coupon_post_tab", function() {
		"topic" === couponType ? window.location.href = "/live/coupon/couponInfo.htm?codeId=" + $(this).attr("attr-codeid") + "&_=" + (new Date).getTime() : "channel" === couponType && (window.location.href = "/live/channelCoupon/couponInfo.htm?codeId=" + $(this).attr("attr-codeid") + "&_=" + (new Date).getTime())
	});
	$(document).on("click", ".used_derail_qlbga", function() {
		$(".user_head").attr("src", $(this).attr("attr-pic"));
		$(".uer_state").text($(this).parents("dd").find(".useState var").text());
		$(".banner_title").text($(this).attr("attr-name"));
		$(".user_time").text($(this).attr("attr-time"));
		$(".coupon_detail_box").show();
		var a = $(this).data("state"),
			c = $(".coupon_detail_box #coupon_time_msg").html(),
			b;
		"used" === a ? b = c.replace("\u8fc7\u671f\u65f6\u95f4", "\u4f7f\u7528\u65f6\u95f4") : "bind" === a && (b = c.replace("\u4f7f\u7528\u65f6\u95f4", "\u8fc7\u671f\u65f6\u95f4"));
		$(".coupon_detail_box #coupon_time_msg").html(b)
	});
	$(document).on("click", ".couponBox .qlGbBg", function() {
		$(".couponBox").hide()
	});
	$(document).switchBtn({
		obj: "#channel_cuppon_switch",
		switchType: "complex",
		functionafter: "Y",
		isOn: $("#channel_cuppon_switch").attr("attr-ison"),
		onFunction: function() {
			gb("Y")
		},
		offFunction: function() {
			gb("N")
		}
	});
	$(document).on("click", "#channel-topic-promote", function() {
		$(".pushChannelBox").data("thischannelid", $(this).data("thischannelid"));
		qlSlBoxShow(".pushChannelBox")
	});
	$(document).on("click", ".pushChannelBox .tlbtn_confirm", function() {
		if (0 >= $("#NqChannelList dd").length) return alertMsg("\u6682\u65e0\u7cfb\u5217\u8bfe\u8bfe\u7a0b\uff0c\u8bf7\u65b0\u5efa\u8bdd\u9898\u518d\u8fdb\u884c\u63a8\u9001", 1), !1;
		var a = Number($(".push_span_2 var").html()) - 1,
			c = $(".pushChannelBox").data("thischannelid");
		0 <= a ? ($(".loadingBox").show(), $.ajax({
			type: "GET",
			url: "/live/channel/push.htm",
			data: {
				channelId: c
			},
			success: function(c) {
				$(".pushChannelBox").hide();
				$(".loadingBox").hide();
				"200" == c.state.code ? ($(".push_span_2 var").html(a), $(document).minTipsBox({
					tipsContent: "\u6d88\u606f\u63a8\u9001\u6210\u529f",
					tipsTime: 1
				})) : $(document).minTipsBox({
					tipsContent: c.state.msg,
					tipsTime: 1
				})
			},
			error: function(a) {
				$(document).minTipsBox({
					tipsContent: a.state.msg,
					tipsTime: 1
				});
				$(".loadingBox").hide()
			}
		})) : $(document).minTipsBox({
			tipsContent: "\u63a8\u9001\u6b21\u6570\u5df2\u8fbe\u4e0a\u9650",
			tipsTime: 1
		})
	});
	var bE = $(".percent_tips");
	$("#percent_input").keyup(function() {
		var a = $(this).val();
		/^[1-9]+[0-9]*]*$/.test(a) && 0 < a && 50 >= a ? ($(".percent_tips_var1").text(a), $(".percent_tips_var2").text((99.4 - a).toFixed(1)), $(".percent_tips").show()) : bE.hide()
	});
	$(document).on("click", ".blktlbtn_setPercent", function() {
		bF = Number($("#percent_input").val());
		Xa = Number($("#count_input").val());
		var a = isNumberValid(Xa, 1, 20, "\u751f\u6210\u6570\u91cf"),
			c = isNumberValid(bF, 1, 80, "\u5206\u6210\u6bd4\u4f8b"),
			b = {
				shareEarningPercent: bF,
				shareNum: Xa,
				type: type,
				businessId: businessId,
				isShareFree: enableTopicFree ? "Y" : "N"
			};
		if (0 < $(".expiry_date_dl").length) {
			var e = "";
			"" !== $(".expiry_date_dl .btn_qlcheckbox.on").attr("data-day") && (e = $(".choose_expiry_date").attr("data-day"));
			b.beInviterDay = e
		}
		$(document).on("click", ".expiry_date_dl dd", function() {
			$(this).addClass("on")
		});
		a && c && (isSetPercent = !1, $.ajax({
			type: "POST",
			url: "/topic/share/saveshare.htm",
			contentType: "application/json",
			data: JSON.stringify(b),
			success: function(a) {
				a = a.state;
				"200" == a.code ? (setSharePercent(businessId, bF), $(".blktlbtn_setPercent").html("\u8bbe\u7f6e\u6bd4\u4f8b"), alertMsg("\u8bbe\u7f6e\u6210\u529f", 1), "live" === type ? window.location.href = "/topic/share/shareuser/live.htm?businessId=" + businessId + "&restime=" + (new Date).getTime() : "topic" === type && (window.location.href = "/topic/share/shareuser/" + businessId + ".htm?topicId=" + businessId + "&joinType=auth&restime=" + (new Date).getTime())) : alertMsg(a.msg, 1)
			},
			error: function(a) {
				alertMsg("\u7cfb\u7edf\u51fa\u9519", 1)
			}
		}))
	});
	var bF, Xa;
	window.onload = function() {
		/(addshare)\/(\d+(\/\d+)?).htm$/ig.test(location.pathname) && setTimeout(Tb, 500);
		isiOS() || isAndroid() || $(".pc_tip").show()
	};
	/live\/channel\/addChannel/.test(location.href) && Ub();
	$(".btnChannelLogo").click(function() {
		$(".uploadChannelLogo img").attr("src", $(".btnChannelLogo img").attr("src"));
		qlSlBoxShow(".uploadChannelLogoBox")
	});
	0 < $(".uploadChannelLogo").length && new imgUpload($(".uploadChannelLogo"), {
		folder: "channelLogo",
		onComplete: function(a) {
			$(".uploadChannelLogo img").attr("src", a + "@300h_300w_1e_1c_2o")
		}
	});
	$(".uploadChannelLogoBox .tlbtn_confirm").click(function() {
		$(".btnChannelLogo img").attr("src", $(".uploadChannelLogo img").attr("src"));
		$(".uploadChannelLogoBox").hide()
	});
	$(".btnChannelName").click(function() {
		var a = $(this).text().trim();
		"\u672a\u8bbe\u7f6e" != a && $(".channelNameBox .qlMT_input").val(a);
		qlSlBoxShow(".channelNameBox")
	});
	$(".channelNameBox .tlbtn_confirm").click(function() {
		var a = $(".channelNameBox .qlMT_input").val();
		validLegal("text", "\u7cfb\u5217\u8bfe\u540d\u79f0", a, 40) && ($(".btnChannelName").text(a), $(".channelNameBox").hide())
	});
	$(".goto-page").click(function() {
		var a = $(this);
		hb("Y", function() {
			window.location.href = a.attr("attr-href")
		})
	});
	0 < $(".chooseChannelType").length, $(document).on("click", ".btnCategoryType.nothastype", function() {
		alertMsg("\u6ca1\u6709\u53ef\u9009\u62e9\u7684\u5206\u7c7b\uff01")
	});
	$(document).on("click", ".btnCategoryType.hastype", function() {
		$(".categoryTypeBox .qlMT_textarea").val($(this).text());
		qlSlBoxShow(".categoryTypeBox")
	});
	$(document).on("click", ".categoryTypeBox .addbtn_confirm", function() {
		var a = $(".chooseChannelType .active").attr("attr-type"),
			c = $(".chooseChannelType .active span").html();
		$(".btnCategoryType").attr("attr-type", a);
		$("#category").val(a);
		$(".btnCategoryType").html(c);
		$(".categoryTypeBox").hide()
	});

	$(document).on("click", ".btnStatus.hastype", function() {
		$(".statusBox .qlMT_textarea").val($(this).text());
		qlSlBoxShow(".statusBox")
	});
	$(document).on("click", ".statusBox .addbtn_confirm", function() {
		
		var a = $(".chooseStatus .active").attr("attr-type"),
			c = $(".chooseStatus .active span").html(),
			d = $(".chooseStatus .active").attr("attr-name");
		console.log(a);
		console.log(c);
		console.log(d);
		$(".videotype").hide();
		$("."+d).show();
		$(".btnStatus").attr("attr-type", a);
		$("#status").val(a);
		$(".btnStatus").html(c);
		$(".statusBox").hide()
	});

	$(document).on("click", ".btnVideoType.hastype", function() {
		$(".videoTypeBox .qlMT_textarea").val($(this).text());
		qlSlBoxShow(".videoTypeBox")
	});
	$(document).on("click", ".videoTypeBox .addbtn_confirm", function() {
		
		var a = $(".chooseVideoType .active").attr("attr-type"),
			c = $(".chooseVideoType .active span").html(),
			d = $(".chooseVideoType .active").attr("attr-name");
		$(".videotype").hide();
		$("."+d).show();
		$(".btnVideoType").attr("attr-type", a);
		$("#video").val(a);
		$(".btnVideoType").html(c);
		$(".videoTypeBox").hide()
	});

	$(document).on("click", ".CommontType.hastype", function() {
		$(".CommontTypeBox .qlMT_textarea").val($(this).text());
		qlSlBoxShow(".CommontTypeBox")
	});
	$(document).on("click", ".CommontTypeBox .addbtn_confirm", function() {
		var a = $(".chooseCommontType .active").attr("attr-type"),
			c = $(".chooseCommontType .active span").html();
		$(".CommontType").attr("attr-type", a);
		$("#commont").val(a);
		$(".CommontType").html(c);
		$(".CommontTypeBox").hide()
	});

	$(document).on("click", ".livestatus.hastype", function() {
		$(".LivestatusBox .qlMT_textarea").val($(this).text());
		qlSlBoxShow(".LivestatusBox")
	});
	$(document).on("click", ".LivestatusBox .addbtn_confirm", function() {
		var a = $(".chooselivestatusType .active").attr("attr-type"),
			c = $(".chooselivestatusType .active span").html();
		console.log(c);
		$(".livestatus").attr("attr-type", a);
		$("#livestatus").val(a);
		$(".livestatus").html(c);
		$(".LivestatusBox").hide()
	});
	$(document).on("click", ".reward.hastype", function() {
		$(".RewardBox .qlMT_textarea").val($(this).text());
		qlSlBoxShow(".RewardBox")
	});
	$(document).on("click", ".RewardBox .addbtn_confirm", function() {
		var a = $(".chooserewardType .active").attr("attr-type"),
			c = $(".chooserewardType .active span").html();
		console.log(c);
		$(".reward").attr("attr-type", a);
		$("#reward").val(a);
		$(".reward").html(c);
		$(".RewardBox").hide()
	});

	$(document).on("click", ".style.hastype", function() {
		$(".StyleBox .qlMT_textarea").val($(this).text());
		qlSlBoxShow(".StyleBox")
	});
	$(document).on("click", ".StyleBox .addbtn_confirm", function() {
		var a = $(".choosestyleType .active").attr("attr-type"),
			c = $(".choosestyleType .active span").html();
		$(".style").attr("attr-type", a);
		$("#style").val(a);
		$(".style").html(c);
		$(".StyleBox").hide()
	});

	
	$(document).on("click", ".chooselivestatusType ul li", function() {
		console.log(111);
		$(this).addClass("active").siblings("li").removeClass("active")
	});
	$(document).on("click", ".chooserewardType ul li", function() {
		$(this).addClass("active").siblings("li").removeClass("active")
	});
	$(document).on("click", ".choosestyleType ul li", function() {
		$(this).addClass("active").siblings("li").removeClass("active")
	});
	$(document).on("click", ".chooseCommontType ul li", function() {
		$(this).addClass("active").siblings("li").removeClass("active")
	});
	$(document).on("click", ".chooseChannelType ul li", function() {
		$(this).addClass("active").siblings("li").removeClass("active")
	});
	$(document).on("click", ".chooseVideoType ul li", function() {
		$(this).addClass("active").siblings("li").removeClass("active")
	});
	$(document).on("click", ".chooseStatus ul li", function() {
		$(this).addClass("active").siblings("li").removeClass("active")
	});
	$(document).on("click", ".btnChannelTopics", function() {
		"\u672a\u8bbe\u7f6e" != $(this).text().trim() && $(".channelTopicsBox .qlMT_input").val($(this).text().trim());
		qlSlBoxShow(".channelTopicsBox")
	});
	$(document).on("click", ".channelTopicsBox .tlbtn_confirm", function() {
		var a = $(".channelTopicsBox .qlMT_input").val();
		"" == a || "0" === a ? ($(".btnChannelTopics p").text("\u672a\u8bbe\u7f6e"), $(".channelTopicsBox").hide()) : isNumberValid(Number(a), 1, 9999, "\u5f00\u8bfe\u7684\u8282\u6570") && ($(".btnChannelTopics p").text(a), $(".channelTopicsBox").hide())
	});
	$(".btnSetAbsolutely").click(function() {
		qlSlBoxShow(".setAbsolutelyBox")
	});
	$(".setAbsolutelyBox .tlbtn_confirm").click(function() {
		var a = $(".setAbsolutelyBox .sCharge_input").val();
		if ("0" == a || isDecimalValid(a, 1, 5E4, "\u56fa\u5b9a\u6536\u8d39")) {
			var c = !0;
			$(".btnSetAbsolutely .price-value").text("\uffe5" + a);
			$(".btnSetAbsolutely").data("chargeConfigs", "0," + a);
			if ($(".channel-price-switch").hasClass("swon")) {
				if (c = "0" == $(".discount_input").val() || isDecimalValid($(".discount_input").val(), 1, 5E4, "\u7279\u4ef7\u4f18\u60e0")) $(".btnSetAbsolutely .price-value").text("\uffe5" + $(".discount_input").val()), $(".btnSetAbsolutely .price-title").show()
			} else $(".btnSetAbsolutely .price-title").hide();
			c && $(".setAbsolutelyBox").hide()
		}
	});
	$(document).on("click", ".channel-price-switch", function(a) {
		a.stopPropagation();
		a.preventDefault();
		$(this).toggleClass("swon");
		$(".discount_box").toggleClass("hide")
	});
	$(".btnSetFlexible").click(function() {
		qlSlBoxShow(".setFlexibleBox")
	});
	$(".setFlexibleBox .tlbtn_confirm").click(function() {
		var a, c = [],
			b = [];
		$(".charge_type_table .months").each(function() {
			a = isNumberValid($(this).val(), 1, 24, "\u6708\u4efd");
			if (!a) return a
		});
		var e;
		$(".charge_type_table .price").each(function() {
			e = isDecimalValid($(this).val(), 1, 5E4, "\u91d1\u989d");
			if (!e) return e
		});
		if (a && e) {
			$(".charge_type_table").each(function() {
				c.push($(this).find(".months").val());
				b.push($(this).find(".price").val())
			});
			var g = "",
				d = "";
			$(".charge_type_table tr").each(function() {
				g += $(this).find(".price").val() + "," + $(this).find(".months").val() + ";";
				2 > $(this).index() && (d += " \u00a5" + $(this).find(".price").val() + "/" + $(this).find(".months").val() + "\u6708")
			});
			var l = $("#channel-flexible-charge-text");
			l.text(d);
			l.data("chargeConfigs", g.substr(0, g.length - 1));
			$(".setFlexibleBox").hide()
		}
	});
	$(".btnAddCType").click(function() {
		10 > $(".charge_type_table tr").length ? ($(".charge_type_table").append('<tr><td><input class="months" placeholder="\u8f93\u5165\u6708\u6570"/></td><td>\u4e2a\u6708\u6536\u53d6</td><td><input class="price" placeholder="\u8f93\u5165\u91d1\u989d"/></td><td>\u5143</td><td><a class="qlbgi_del"></a></td></tr>'), $(".charge_type_table tr:last-child .months").focus()) : alertMsg("\u6700\u591a\u521b\u5efa10\u79cd\u6536\u8d39\u7c7b\u578b")
	});
	"" == $(".btnChannelName").text().trim() && $(".btnChannelName").text("\u672a\u8bbe\u7f6e");
	$(document).on("click", ".qlbgi_del", function() {
		var a = $(this);
		$(document).popBox({
			boxContent: "\u786e\u5b9a\u5220\u9664\u8be5\u6536\u8d39\u7c7b\u578b\u5417\uff1f",
			btnType: "both",
			confirmFunction: function() {
				a.parents("tr").remove()
			}
		})
	});
	var bG = !0;
	$(".setNewChannel").click(hb);
	0 < $(".setFlexibleBox").length && $.ajax({
		type: "POST",
		url: "/live/channelChargeconfig/getChargeList.htm",
		data: {
			channelId: channelId
		},
		success: function(a) {
			a = a.model.chargeConfigs;
			if (0 < a.length) {
				$(".btn_qlcheckbox").addClass("disabled");
				var c = "",
					b = "";
				if (1 == a.length && 0 == a[0].chargeMonths) $(".btnSetAbsolutely .price-value").text("\uffe5" + a[0].amount), $(".setAbsolutelyBox .sCharge_input").val(a[0].amount), $(".btnSetAbsolutely").data("chargeConfigs", "0," + a[0].amount), $(".discount_input").val(a[0].discount), a[0].discountStatus && "Y" === a[0].discountStatus && ($(".channel-price-switch").addClass("swon"), $(".btnSetAbsolutely .price-title").show(), $(".discount_box").removeClass("hide"), $(".btnSetAbsolutely .price-value").text("\uffe5" + a[0].discount));
				else {
					$(".charge_type_table").html("");
					for (i = 0; i < a.length; i++) {
						var e = a[i].chargeMonths,
							g = a[i].amount;
						$(".charge_type_table").append('<tr><td><input class="months" placeholder="\u8f93\u5165\u6708\u6570"/></td><td>\u4e2a\u6708\u6536\u53d6</td><td><input class="price" placeholder="\u8f93\u5165\u91d1\u989d"/></td><td>\u5143</td><td><a class="qlbgi_del"></a></td></tr>');
						c += g + "," + e + ";";
						2 > i && (b += " \u00a5" + g + "/" + e + "\u6708");
						$(".charge_type_table tr").eq(i).find(".months").val(e);
						$(".charge_type_table tr").eq(i).find(".price").val(g)
					}
					$(".btnSetFlexible var").text(b);
					$(".btnSetFlexible").data("chargeConfigs", c.substr(0, c.length - 1))
				}
				Vb(a)
			}
		}
	});
	var bH = !0,
		ib = 2;
	0 < $("#channelList").length && pageLoadCommon($("#channelList"), Wb);
	$("#isMember").click(function() {
		qlSlBoxShow(".renewModal")
	});
	$(".tlbtn_renew").click(function() {
		$(".renewModal").hide();
		window.isHaveCoupon ? showBottomBox(".channelPayList") : showBottomBox("#channelPriceBox")
	});
	var bI = !0,
		Ea = !1;
	loadCnTopicPage = 1;
	topicPageSize = 20;
	0 < $("#ChannelRoom").length && (jb(), pageLoadCommon($("#ChannelRoom"), jb), $(".channel-tabbar .active").click());
	$(".btnShowPList").click(function() {
		window.isHaveCoupon || showBottomBox("#channelPriceBox")
	});
	$(document).on("click", "#doPay, .payForMember", function() {
		$(".loadingBox").show();
		A = "CHANNEL";
		var a = Number((100 * Number($(this).attr("attr-money"))).toFixed(0)),
			c = $(this).attr("attr-id"),
			b = {
				id: channelId,
				type: "channel",
				payType: "CHANNEL"
			},
			e = {
				topicId: "0",
				chargeConfigId: c
			};
		0 === a ? kb(c) : wxPayCommon(userId, "", "", A, a, e, function() {
			l(arguments, {
				channelId: channelId
			})
		}, b)
	});
	$(document).on("click", "#popBottomWindow", function() {
		showBottomBox(".channelPayList")
	});
	$(document).on("click", "#btnPayFree", function() {
		var a = $(this).attr("attr-id");
		$(".loadingBox").show();
		kb(a)
	});
	0 < $(".channel_describ_row").length && 36 < $(".channel_describ_row article").height() && ($(".channel_describ_row").addClass("overline"), $(document).on("click", ".channel_describ_row", function() {
		$(".channel_describ_row").toggleClass("overline")
	}));
	0 < $(".channelPayList").length && (!isLiveManager && isHaveCoupon ? iMPay ? $(".channelPayList").parent(".bottom_box").hide() : showBottomBox(".channelPayList") : $(".channelPayList").parent(".bottom_box").hide(), $(document).on("click", ".inner_list li", function(a) {
		$(this).index();
		$(this).parent().children();
		$(this).siblings().removeClass("on");
		$(this).addClass("on");
		var c = Number($(this).attr("attr-money"));
		a = 0 < c - qlCouponMoney ? c - qlCouponMoney : 0;
		c = c > qlCouponMoney ? qlCouponMoney : c;
		$(".payMoney").text(a.toFixed(2));
		$(".payMoney").attr("attr-id", $(this).attr("attr-id"));
		$(".btnPayChannel").text($(this).data("phrase") + "\uff08\u5df2\u4f7f\u7528\u4f18\u60e0\u7801\u62b5\u6263\uffe5" + c + "\uff09");
		$(".btnPayChannel").attr("attr-id", $(this).attr("attr-id"));
		$(".btnPayChannel").attr("attr-money", a.toFixed(2));
		$("#btnPayFree").attr("attr-id", $(this).attr("attr-id"));
		$("#freeMoney").text(c.toFixed(2))
	}), "flexible" === chargeType && isHaveCoupon && !isLiveManager && $(".inner_list li:first").trigger("click"));
	if (0 < $(".ticket-exit-gift").length) {
		var bJ = function(a, c) {
				if (0 === a) return na.text("\uffe5   0"), R.text(c), oa.text(c), !1;
				if (1E4 < a) return na.text("\uffe5   " + a.toFixed(2)), R.text(c), oa.text(c), pa = !1, alertMsg("\u62b1\u6b49\uff01\u60a8\u7684\u8d60\u793c\u8d85\u8fc7\u4e8650000\u5143\u7684\u4e0a\u9650~<br/>\u8bf7\u51cf\u5c11\u8d60\u793c\u6570\u91cf\u6216\u591a\u6b21\u8d2d\u4e70"), !1;
				if (0 >= c) return na.text("\uffe5   0"), R.text(0), oa.text(0), Ya = !1;
				Ya = pa = !0;
				na.text("\uffe5   " + a.toFixed(2));
				R.text(c);
				oa.text(c);
				return !0
			},
			ra = function(a) {
				var c = Number(R.text()),
					b = Number("absolutely" == chargeType ? $("#sum").attr("attr-price") : $(".channel_type .on").attr("attr-price")),
					e = c * b;
				"increase" == a ? (c++, e = c * b) : "decrease" == a && (c--, e = c * b);
				bJ(e, c) ? ($("#doGift").removeClass("disable"), qa = !1) : (qa = !0, $("#doGift").addClass("disable"))
			};
		$(document).on("click", ".ticket-exit-gift", function() {
			qlSlBoxShow(".giftPack")
		});
		var R = $(".giftPack .count"),
			oa = $("#giftCount"),
			na = $("#sum"),
			qa = !1,
			pa = !0,
			Ya = !0,
			qa = $("#doGift").hasClass("disable"),
			pa = !$("#doGift").hasClass("do_not_increase");
		$(document).on("click", ".decrease", function() {
			Ya && ra("decrease")
		}).on("click", ".increase", function() {
			pa && ra("increase")
		}).on("click", "#doGift", function() {
			if (!qa) {
				A = "GIFT_CHANNEL";
				localStorage.setItem("wxPayTupe", "GIFT_CHANNEL");
				$(".loadingBox").show();
				var a = $(".channel_type .on").attr("attr-id"),
					c = {
						id: channelId,
						type: "channel",
						payType: A
					},
					a = {
						topicId: "0",
						chargeConfigId: a,
						giftCount: $(".count").text()
					};
				wxPayCommon(window.userId, window.liveId, "", A, 0, a, l, c)
			}
		}).on("click", "#viewGift", function() {
			var a = $(this).attr("data-gift-id");
			window.location.href = "/wechat/page/channel/gift/" + a
		}).on("click", "#close", function() {
			$(".giftPack").hide()
		});
		$(document).on("click", ".next", function() {
			0 < $(".channel_type").find(".on").next().length ? $(".channel_type").find(".on").removeClass("on").next().addClass("on") : $(".channel_type span").removeClass("on").eq(0).addClass("on");
			ra()
		}).on("click", ".pre", function() {
			if (0 < $(".channel_type").find(".on").prev().length) $(".channel_type").find(".on").removeClass("on").prev().addClass("on");
			else {
				var a = $(".channel_type span").length - 1;
				$(".channel_type span").removeClass("on").eq(a).addClass("on")
			}
			ra()
		})
	}
	var bK = !0;
	$(document).on("click", ".shareCourseBtn", function() {
		bK && (bK = !1, "" != shareKey && "charge" == liveType ? window.location.href = "/topic/share/shareCardTemplate.htm?shareType=topic&type=0&shareKey=" + shareKey : $.ajax({
			type: "POST",
			url: "/topic/share/saveshare.htm",
			contentType: "application/json",
			data: JSON.stringify({
				businessId: topicId,
				type: "topic"
			}),
			success: function(a) {
				var c = a.state;
				a = a.data;
				"200" == c.code ? window.location.href = "/topic/share/shareCardTemplate.htm?shareType=topic&type=0&shareKey=" + a.shareKey : ($(document).minTipsBox({
					tipsContent: c.msg,
					tipsTime: 1
				}), bK = !0)
			},
			error: function(a) {
				bK = !0;
				$(document).minTipsBox({
					tipsContent: a.msg,
					tipsTime: 1
				})
			}
		}))
	}).on("click", ".course_bottom", function() {
		$(".shareCourseBox").hide()
	});
	$(document).on("click", "#coupon_recieve_button", function(a) {
		a.preventDefault();
		a = String(Date.now());
		var c = "",
			c = "channel" === window.pageType ? "/live/channelCoupon/batchCodeGet/" + window.channelId + "/" + window.codeId + ".htm" : "vip" === window.pageType ? "/live/vipCoupon/batchCodeGet/" + window.liveId + "/" + window.codeId + ".htm" : "/live/batchCodeGet/" + window.topicId + "/" + window.codeId + ".htm";
		$.ajax({
			type: "POST",
			url: c,
			data: {
				time: a
			},
			success: function(a) {
				"200" === a.statusCode ? window.location.href = "channel" === window.pageType ? "/live/channel/channelPage/" + window.channelId + ".htm" : "vip" === window.pageType ? "/live/whisper/vip.htm?liveId=" + window.liveId : "/topic/" + window.topicId + ".htm" : "205" === a.statusCode ? ($(".coupon_recieve_button").addClass("overtime"), $(".coupon_recieve_button").text("\u5f88\u9057\u61be\uff0c\u60a8\u6765\u665a\u4e86\u4e00\u6b65"), $(".coupon_recieve_button").removeAttr("id")) : alertMsg(a.msg)
			},
			error: function(a) {
				alertMsg(a.msg)
			}
		})
	});
	$(document).on("click", "#channel-options .delChannel", function(a) {
		a.stopPropagation();
		0 != window.activeChannel.sum ? $(document).popBox({
			boxType: "",
			boxContent: "\u8be5\u7cfb\u5217\u8bfe\u5df2\u6709\u62a5\u540d\u8bb0\u5f55\uff0c\u4e0d\u53ef\u5220\u9664\uff0c\u4ec5\u53ef\u9690\u85cf",
			btnType: "confirm",
			confirmName: "\u6211\u77e5\u9053\u4e86",
			confirmFunction: function() {
				hideBottomBox("#channel-options")
			}
		}) : $(document).popBox({
			boxType: "",
			boxContent: "\u662f\u5426\u5220\u9664\u6b64\u7cfb\u5217\u8bfe",
			btnType: "both",
			confirmFunction: Yb,
			cancelFunction: Xb
		})
	});
	$(document).on("click", ".single_buy_btn", function(a) {
		a.stopPropagation();
		a = Number($(this).parents(".topic-btnbar").data("money")).toFixed(0);
		var c = String($(this).parents(".topic-btnbar").data("topicid"));
		$(".loadingBox").show();
		A = "COURSE_FEE";
		wxPayCommon(userId, liveId, c, A, a, {}, function() {
			l(arguments, {
				topicId: c
			})
		}, {
			id: c,
			type: "topic",
			payType: "COURSE_FEE"
		})
	});
	$(document).on("click", ".btn_switch_setSingleBuy", function() {
		function a() {
			$(".loadingBox").show();
			$.ajax({
				type: "POST",
				url: "/live/channel/singlebuy.htm",
				data: {
					status: "N",
					topicId: g
				},
				success: function(a) {
					200 === a.state.code ? (alertMsg("\u5df2\u5173\u95ed\u5355\u8282\u4ed8\u8d39"), $(this).removeClass("swon"), $(".topic-btnbar[data-topicId=" + g + "]").data("status", "N"), e.data("isSingleBuy", "N"), b = "N", d.find(".btn_switch_setSingleBuy").removeClass("swon"), $('.topic-btnbar[data-topicId="' + g + '"]').parents("dd").find(".topic-type-pay").remove(), $('.topic-btnbar[data-topicId="' + g + '"] .single_buy_num_owner').hide(), $.when(d.find(".setFree").show()).then(function() {
						$(".loadingBox").hide()
					})) : (alertMsg(a.state.msg), $(".loadingBox").hide())
				},
				error: function(a) {
					$(".loadingBox").hide();
					alertMsg(a.state.msg)
				}
			})
		}
		function c() {
			var a = B.parents(".topic-btnbar").data("money") || "0";
			$("#singleBuy-charge").val("");
			"0" != a && $("#singleBuy-charge").val(Number(a) / 100);
			$("#switchSingleBuyBox").show();
			$("#switchSingleBuyBox .tlbtn_cancel").click(function() {
				$("#switchSingleBuyBox").hide()
			});
			$("#switchSingleBuyBox .tlbtn_confirm").click(function(a) {
				var c = $(this).parents("#switchSingleBuyBox").find("#singleBuy-charge").val().trim();
				isDecimalValid(c, 1, 5E4, "\u5355\u8282\u8d2d\u4e70\u91d1\u989d") && ($(".loadingBox").show(), $.ajax({
					type: "POST",
					url: "/live/channel/singlebuy.htm",
					data: {
						money: c,
						status: "Y",
						topicId: g
					},
					success: function(a) {
						200 === a.state.code ? (alertMsg("\u5df2\u5f00\u542f\u5355\u8282\u4ed8\u8d39"), d.find(".setFree").hide(), d.find(".btn_switch_setSingleBuy").addClass("swon"), $('.topic-btnbar[data-topicId="' + g + '"]').parents("dd").find(".topic-type-bar").html('<i class="topic-type-pay">\uffe5' + c + "</i>"), $.when($("#switchSingleBuyBox").hide()).then(function() {
							$(".loadingBox").hide()
						}), e.data("isSingleBuy", "Y"), b = "Y", $(".topic-btnbar[data-topicId=" + g + "]").data("status", "Y"), B.parents(".topic-btnbar").data("money", String(100 * c))) : ($(".loadingBox").hide(), alertMsg(a.state.msg))
					},
					error: function(a) {
						$(".loadingBox").hide();
						alertMsg(a.state.msg)
					}
				}))
			})
		}
		var b = $(this).parents(".setSingleBuy").data("isSingleBuy"),
			e = $(this).parents(".setSingleBuy"),
			g = $(this).parents("#topicMenu").data("theTopicId"),
			d = $(this).parents("#topicMenu");
		"Y" === b ? a() : c()
	});
	$(document).on("click", ".qlbgi_reward_heart, .qlbga_reward_heart", function() {
		qlSlBoxShow("#hot-live-tips")
	});
	$(document).on("click", "#hot-live-tips .tlbtn_cancel", function() {
		$("#hot-live-tips").hide()
	});
	$(document).on("click", ".qlbgi_reward_people, .qlbga_reward_people", function() {
		qlSlBoxShow("#dai-live-tips")
	});
	$(document).on("click", "#dai-live-tips .tlbtn_cancel", function() {
		$("#dai-live-tips").hide()
	});
	$(document).on("click", ".qlbgi_v_auth, .qlbga-v-live", function() {
		qlSlBoxShow("#v-live-tips")
	});
	$(document).on("click", "#v-live-tips .tlbtn_cancel", function() {
		$("#v-live-tips").hide()
	});
	if (0 < $(".realname-y").length || 0 < $(".realname-n").length) {
		var bL = $(".realname-n").attr("attr-liveId"),
			ec = $(".realname-n").attr("attr-type"),
			fc = $(".realname-n").attr("attr-ismanager");
		if ($(".realname-n").attr("isLiveIndex") && "true" != isLogIn) return !1;
		lb(bL, ec, function(a, c) {
			"audited" == a ? ($(".realname-n").remove(), $(".realname-y").show()) : ($(".realname-y").remove(), bL && fc ? $(".realname-n").show() : ($(".realname-y").remove(), $(".realname-n").remove()), c && $(".realname-n").attr("attr-pop", "true"), a ? "auditing" == a && $(".realname-n").attr("attr-status", "ing") : $(".realname-n").remove())
		});
		$(document).on("click", ".realname-y", function() {
			$("#real-name-tips").find(".qlMT_content").html("<span>\u5df2\u901a\u8fc7\u5b9e\u540d\u8ba4\u8bc1</span>");
			qlSlBoxShow("#real-name-tips")
		}).on("click", ".realname-n", function() {
			"ing" == $(this).attr("attr-status") ? $("#real-name-tips").find(".qlMT_content").addClass("isrealing").html("<span>\u76f4\u64ad\u95f4\u5b9e\u540d\u8ba4\u8bc1\u6b63\u5728\u5ba1\u6838\u4e2d<br/>\u8bf7\u8010\u5fc3\u7b49\u5f85</span>") : $("#real-name-tips").find(".qlMT_content").addClass("unreal");
			qlSlBoxShow("#real-name-tips")
		});
		$(document).on("click", "#real-name-tips .tlbtn_cancel", function() {
			$("#real-name-tips").hide()
		})
	}
	window.enableTopicFree = !1;
	if (0 < $(".btn_switch_add_user").length) $(document).on("click", ".btn_switch_add_user", function() {
		var a = $(this);
		a.hasClass("swon") ? (enableTopicFree = !1, a.removeClass("swon")) : $(document).popBox({
			boxType: "\u201csuccess",
			boxContent: "\u662f\u5426\u5f00\u542f\u5f53\u524d\u8bdd\u9898\u5bf9\u5206\u9500\u5546\u514d\u8d39",
			btnType: "both",
			confirmName: "\u786e\u5b9a",
			cancelName: "\u53d6\u6d88",
			confirmFunction: function() {
				enableTopicFree = !0;
				a.addClass("swon")
			},
			cancelFunction: function() {}
		})
	});
	$(document).on("click", ".qlbgi_teacher_auth,.qlbga-t-live", function() {
		qlSlBoxShow("#t-live-tips")
	});
	$(document).on("click", "#t-live-tips", function() {
		$("#t-live-tips").hide()
	});
	$(document).on("click", ".openShow", function() {
		$(".openShow").hide();
		localStorage.setItem("openShow", "Y")
	});
	var N = !0;
	$(document).on("click", ".businessBtn", function() {
		var a = $(".businessValue").val();
		if (validLegal("money", "\u516c\u5bf9\u516c\u6253\u6b3e\u91d1\u989d", a, 5E5, 2E4)) {
			$(".loadingBox").show();
			var c = $(this).attr("attr-id"),
				a = Number(100 * a).toFixed(0);
			N && (N = !1, $.ajax({
				type: "POST",
				url: "/live/reward/ptpApply.htm",
				data: {
					liveId: c,
					money: a
				},
				success: function(a) {
					$(".loadingBox").hide();
					N = !0;
					"200" == a.statusCode ? ($(document).minTipsBox({
						tipsContent: "\u63d0\u4ea4\u6210\u529f\uff0c\u53ef\u5728\u63d0\u73b0\u660e\u7ec6\u5904\u67e5\u770b\u8fdb\u5ea6\uff01",
						tipsTime: 1.5
					}), window.location.href = "/live/reward/liveReward/" + c + ".htm?_=" + (new Date).getTime()) : $(document).minTipsBox({
						tipsContent: a.msg,
						tipsTime: 1.5
					})
				},
				error: function(a) {
					$(document).minTipsBox({
						tipsContent: a.msg,
						tipsTime: 1
					});
					N = !0;
					$(".loadingBox").hide()
				}
			}))
		}
	});
	0 < $(".openShow").length && !localStorage.getItem("openShow") && $(".openShow").show();
	$("#live-type-list li").click(function() {
		"video" === $(this).data("type") ? ($(".videoAudioTopicsBox .qlMT_top").text("\u89c6\u9891\u4e92\u52a8\u5f62\u5f0f"), qlSlBoxShow(".videoAudioTopicsBox")) : "audio" === $(this).data("type") ? ($(".videoAudioTopicsBox .qlMT_top").text("\u97f3\u9891\u4e92\u52a8\u5f62\u5f0f"), qlSlBoxShow(".videoAudioTopicsBox")) : ($("#live-type-list .icon_checked").removeClass("on"), $(this).find(".icon_checked").addClass("on"))
	});
	$(".videoAudioTopicsBox .tlbtn_confirm").click(function() {
		$(".videoAudioTopicsBox").hide()
	});
	if (0 < $(".staticCouponBox").length) {
		var bM = function(a, c, b, e) {
				$.ajax({
					url: a,
					data: c,
					success: function(a) {
						200 == a.statusCode ? (alertMsg(a.msg), b && b()) : e(a)
					},
					error: function(a) {
						alertMsg("\u7cfb\u7edf\u51fa\u9519")
					},
					complete: function() {
						$(".loadingBox").hide()
					}
				})
			},
			Ob = function(a) {
				"publish" === a ? $("#publishBox").show() : $("#publishBox").hide()
			};
		isChrome() && (I = $("#uri").text(), $("#uri").parent().append($("<span class='tip' id='uri'>" + I + "</span>")), $("#uri").remove());
		var bN = $(this).find(".btn_switch_static").hasClass("swon") ? "publish" : "draft";
		Ob(bN);
		$(document).on("click", ".toggleStatus", function() {
			var a = $(this).find(".btn_switch_static").hasClass("swon") ? "draft" : "publish";
			$(".loadingBox").show();
			bM("/live/coupon/updateStaticCoupon.htm", {
				topicId: topicId,
				status: a
			}, function() {
				$(this).find(".btn_switch_static").toggleClass("swon");
				refreshPage();
				Ob(a)
			}.bind(this))
		}).on("click", "#modifyBtn", function() {
			var a = $("#modifyBtn").text(),
				c = $("#modifyCoupon").val();
			"\u4fee\u6539" === a ? ($("#modifyBtn").text("\u4fdd\u5b58"), $("#modifyBtnCancel").show(), $(".pre_input").hide()) : "\u4fdd\u5b58" === a && validLegal("text", "\u4f18\u60e0\u7801", c, 20) && ($(".loadingBox").show(), bM("/live/coupon/updateStaticCoupon.htm", {
				topicId: topicId,
				couponCode: c
			}, function(a) {
				$("#modifyBtn").text("\u4fee\u6539");
				$("#modifyBtnCancel").hide();
				$(".pre_input").show();
				a = $("#uri").text().replace(new RegExp(topicId + "/.*.htm"), topicId + "/" + c + ".htm");
				$("#uri").text(a);
				$("#uri").attr("href", a);
				$(".pre_input").text(c);
				$("#modifyCoupon").attr("placeholder", c)
			}, function(a) {
				400 == a.statusCode && alertMsg(a.msg)
			}))
		}).on("click", "#uri, .pre_input", function(a) {
			a.preventDefault()
		}).on("click", "#modifyBtnCancel", function() {
			$("#modifyBtn").text("\u4fee\u6539");
			$("#modifyBtnCancel").hide();
			$(".pre_input").show();
			$("#modifyCoupon").val("")
		})
	}
	var bO = {
		isLoad: !0,
		page: 1,
		pageSize: 10,
		init: function() {
			var a = this;
			this.loadMyJoinTopic();
			$(document).on("click", "#myJoinTopicList dd", function() {
				window.location.href = $(this).attr("attr-href")
			});
			pageLoadCommon($(".my_join_topic"), function() {
				a.loadMyJoinTopic()
			})
		},
		loadMyJoinTopic: function() {
			var a = this;
			if (this.isLoad) this.isLoad = !1, $("#loadNone").show().find(".tips_1").text("\u6b63\u5728\u52a0\u8f7d\u4e2d..."), $.ajax({
				type: "POST",
				dataType: "json",
				url: "/live/entity/myJoinTopicData.htm",
				data: {
					page: this.page,
					pageSize: this.pageSize
				},
				success: function(c) {
					if ("200" == c.state.code) {
						$(".page_loading_box").hide();
						var b = $("#myJoinTopicList");
						if (c.data && 0 < c.data.topicList.length) {
							$(".my_join_topic .none_record").hide();
							$("#loadNone").show();
							var e = a.myJoinTopicHmtl(c.data.topicList, c.data.currentTimeMillis);
							c.data.topicList.length < a.pageSize ? (a.isLoad = !1, $("#loadNone .tips_1").text("\u6ca1\u6709\u66f4\u591a\u5185\u5bb9\u4e86")) : (a.isLoad = !0, $("#loadNone .tips_1").text("\u6b63\u5728\u52a0\u8f7d\u4e2d..."));
							0 < b.find("dd").length ? b.append(e) : b.html(e)
						} else 0 == b.find("dd").length ? ($(".my_join_topic .none_record").show(), $("#loadNone").hide()) : (a.isLoad = !1, $("#loadNone .tips_1").text("\u6ca1\u6709\u66f4\u591a\u5185\u5bb9\u4e86"));
						a.page++
					} else $(document).minTipsBox({
						tipsContent: c.state.msg,
						tipsTime: 1
					})
				},
				error: function() {
					$(document).minTipsBox({
						tipsContent: "\u7cfb\u7edf\u6545\u969c\uff0c\u7ef4\u62a4\u4e2d",
						tipsTime: 1
					});
					a.isLoad = !0
				}
			});
			else return this.isLoad = !0, !1
		},
		myJoinTopicHmtl: function(a, c) {
			var b = "",
				e;
			for (e in a) b += this.myJoinTopicTpl(a[e], c);
			return b
		},
		topicStrFilter: function(a) {
			return a && 21 <= a.length ? wordFilter(a.substring(0, 21)) + "..." : wordFilter(a)
		},
		myJoinTopicTpl: function(a, c) {
			var b = a.backgroundUrl ? a.backgroundUrl + "@130h_160w_1e_1c_2o" : "https://img.qlchat.com/qlLive/liveCommon/ticket_header.jpg@130h_160w_1e_1c_2o",
				e = this.topicStrFilter(a.topic),
				b = '<dd attr-href="/topic/' + a.id + '.htm"><div class="clearfix ' + (a.giftFromName ? "show_gift" : "") + '"><span class="topic_banner topic_public qlbgb"><img src="' + b + '" >';
			"beginning" == a.status && (b += c > a.startTimeStamp ? '<b class="b_1">\u6b63\u5728\u76f4\u64ad</b>' : "<b>\u5373\u5c06\u5f00\u59cb</b>");
			return b += '</span><span class="ql_t_title">' + e + '</span><span class="ql_t_date">' + a.beginTime + "</span>" + (a.giftFromName ? '<span class="ql_t_giftname">\u6765\u81ea' + a.giftFromName + "\u7684\u8d60\u793c</span>" : "") + "</div></dd>"
		}
	};
	0 < $(".my_join_topic").length && bO.init();
	if (0 < $(".changeLiveTypeBox").length) {
		var bP = 0,
			Pb = !0;
		$(document).on("click", ".btn_switch_changeTyep", function() {
			$(this).toggleClass("swon");
			Pb = $(this).hasClass("swon")
		}).on("click", ".btn_emp", function() {
			$(".changeLiveTypeBox").hide()
		}).on("click", ".btn_full", function() {
			bP = $("#changeMoney").val();
			if (!validLegal("money", "\u7968\u4ef7", bP, 5E4, 1)) return !1;
			$(".loadingBox").show();
			$.ajax({
				url: "/live/topic/convertTopic.htm",
				data: {
					topicId: window.activeTopic.id,
					money: 100 * bP,
					isKeep: Pb ? "Y" : "N"
				},
				success: function(a) {
					$(".loadingBox").hide();
					"200" == a.statusCode && window.location.reload();
					alertMsg(a.msg)
				},
				complete: function() {
					$(".loadingBox").hide()
				},
				error: function(a) {
					$(".loadingBox").hide();
					alertMsg(a.msg)
				}
			})
		}).on("input", "#changeMoney", function() {
			var a = $(this).val().toString().split(".");
			1 < a.length && 2 < a[1].length && (alertMsg("\u6700\u591a\u8f93\u5165\u5c0f\u6570\u70b9\u540e\u4e24\u4f4d\u7684\u91d1\u989d"), $(this).val(a[0] + "." + a[1].slice(0, 2)))
		}).on("change", "#changeMoney", function() {
			+$(this).val() || alertMsg("\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u6570\u5b57")
		})
	}
	if (0 < $(".autoSharePage").length) {
		var bQ = !0;
		$(document).on("click", ".btn_switch_autoShare", function() {
			$(".btn_switch_autoShare").hasClass("swon") ? ($(".btn_switch_autoShare").removeClass("swon"), $(".autoSharePops .qlMT_top").text("\u5173\u95ed\u81ea\u52a8\u5206\u9500"), $(".autoSharePops .pop_content").text("\u5173\u95ed\u81ea\u52a8\u5206\u9500\uff0c\u5219\u4e0d\u518d\u5bf9\u6240\u6709\u7528\u6237\u5f00\u653e\u5206\u9500\u6743\u9650\uff0c\u4f46\u5df2\u6210\u4e3a\u8bfe\u4ee3\u8868\u7684\u7528\u6237\u4ecd\u4f1a\u4fdd\u7559\u5206\u9500\u6743\u9650\uff0c\u662f\u5426\u5173\u95ed\uff1f"), bQ ? $(".autoSharePops").show() : ($(".save_button").hide(), $("#setPercent").hide())) : ($(".btn_switch_autoShare").toggleClass("swon"), $("#setPercent").show(), $(".save_button").show(), bQ = !1)
		}).on("click", ".autoSharePops .confirm", function() {
			$(".loadingBox").show();
			var a = $(".btn_switch_autoShare").hasClass("swon") ? "Y" : "N";
			$.ajax({
				url: "/topic/share/saveAutoShare.htm",
				data: {
					businessId: window.topicId,
					type: "topic",
					percent: $("#percent").val(),
					isOpen: a
				},
				success: function(a) {
					"200" == a.state.code ? window.location.href = "/topic/" + window.topicId + ".htm?preview=Y&intoPreview=Y" : $(document).minTipsBox({
						tipsContent: a.state.msg,
						tipsTime: 1
					})
				},
				error: function(a) {
					$(document).minTipsBox({
						tipsContent: a.state.msg,
						tipsTime: 1
					})
				},
				complete: function() {
					$(".loadingBox").hide()
				}
			})
		}).on("click", ".autoSharePops .cancel", function() {
			$(".autoSharePops").hide();
			bQ && $(".btn_switch_autoShare").addClass("swon")
		}).on("click", ".save_button", function() {
			if ($(".btn_switch_autoShare").hasClass("swon")) {
				var a = Number($("#percent").val());
				if (isNaN(+a)) return alertMsg("\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u6570\u5b57"), !1;
				if (0 < a - ~~a) return alertMsg("\u53ea\u80fd\u8f93\u5165\u6574\u6570"), !1;
				if (1 > a || 80 < a) return alertMsg("\u8bf7\u8f93\u5165\u5927\u4e8e1\u5c0f\u4e8e80\u7684\u6570\u5b57"), !1
			}
			$(".btn_switch_autoShare").hasClass("swon") ? ($(".autoSharePops .qlMT_top").text("\u5f00\u542f\u81ea\u52a8\u5206\u9500"), $(".autoSharePops .pop_content").text("\u5f00\u542f\u540e\uff0c\u8be5\u8bdd\u9898\u7684\u8bfe\u4ee3\u8868\u6743\u9650\u5bf9\u6240\u6709\u4eba\u5f00\u653e\uff0c\u662f\u5426\u5f00\u653e?")) : ($(".autoSharePops .qlMT_top").text("\u5173\u95ed\u81ea\u52a8\u5206\u9500"), $(".autoSharePops .pop_content").text("\u5173\u95ed\u81ea\u52a8\u5206\u9500\uff0c\u5219\u4e0d\u518d\u5bf9\u6240\u6709\u7528\u6237\u5f00\u653e\u5206\u9500\u6743\u9650\uff0c\u4f46\u5df2\u6210\u4e3a\u8bfe\u4ee3\u8868\u7684\u7528\u6237\u4ecd\u4f1a\u4fdd\u7559\u5206\u9500\u6743\u9650\uff0c\u662f\u5426\u5173\u95ed\uff1f"));
			$(".autoSharePops").show()
		})
	}
	$(document).ready(function() {
		"app" == getCookie("caller") && $(".app-to-hide").hide()
	});
	var bR = {
		type: "channel",
		isLoad: !0,
		page: 1,
		pageSize: 10,
		reqUrl: "/live/entity/getPurchaseRecord.htm",
		fetchRecordLock: !1,
		init: function() {
			var a = this;
			this.checkTab();
			this.loadPurchaseRecord();
			$(document).on("click", ".my_purchase_record_container dl", function(a) {
				"app" == getCookie("caller") && $(this).parents(".my_purchase_record_container").hasClass("my_purchase_record_channel") ? (a.preventDefault(), appJump("jumpChannel", $(this).attr("data-href"))) : window.location.href = $(this).attr("data-href")
			});
			pageLoadCommon($(".my_purchase_record"), function() {
				a.loadPurchaseRecord()
			})
		},
		checkTab: function() {
			var a = this;
			$(".my_purchase_record_tab span").bind("click", function() {
				a.fetchRecordLock || (a.type = $(this).attr("data-type"), $(".my_purchase_record_" + a.type).show().siblings(".my_purchase_record_container").hide(), "gift" !== a.type && a.hideGiftTab(), "gift" === a.type ? (a.reqUrl = "/live/gift/gifts.htm", a.initGiftTab()) : a.reqUrl = "doc" === a.type ? "/doc/api/mydoc.htm" : "live" === a.type ? "/live/entity/vip/mine.htm" : "/live/entity/getPurchaseRecord.htm", $(this).hasClass("on") || (a.resetDefault(), a.loadPurchaseRecord(), pageLoadCommon($(".my_purchase_record"), function() {
					a.loadPurchaseRecord()
				})), $(this).addClass("on").siblings("span").removeClass("on"))
			})
		},
		initGiftTab: function() {
			var a = this;
			this.giftType = "topic";
			$("#gift-tab").show();
			$("#gift-tab li").on("click", function() {
				$(this).hasClass("on") || ($(this).addClass("on").siblings("li").removeClass("on"), a.giftType = $(this).attr("data-type"), a.resetDefault(), a.loadPurchaseRecord(), pageLoadCommon($(".my_purchase_record"), function() {
					a.loadPurchaseRecord()
				}))
			})
		},
		hideGiftTab: function() {
			$("#gift-tab").hide()
		},
		resetDefault: function() {
			this.page = 1;
			this.isLoad = !0;
			$(".my_purchase_record_" + this.type).find(".list").html("");
			$(".my_purchase_record_" + this.type).find(".none_record").hide()
		},
		loadPurchaseRecord: function() {
			var a = this,
				c, b = "application/x-www-form-urlencoded; charset=UTF-8";
			"channel" == this.type ? c = {
				type: this.type,
				page: this.page,
				pageSize: this.pageSize
			} : "live" == this.type ? (b = "application/json", c = JSON.stringify({
				page: {
					page: this.page,
					size: this.pageSize
				}
			})) : c = "gift" === this.type ? {
				type: this.giftType,
				page: this.page,
				pageSize: this.pageSize
			} : {
				type: this.type,
				page: this.page,
				pageSize: this.pageSize
			};
			this.isLoad && (a.fetchRecordLock = !0, this.isLoad = !1, $(".my_purchase_record_" + this.type).find(".box_nothing").show().find(".tips_1").text("\u6b63\u5728\u52a0\u8f7d\u4e2d..."), $.ajax({
				type: "POST",
				dataType: "json",
				url: this.reqUrl,
				data: c,
				contentType: b,
				success: function(c) {
					a.fetchRecordLock = !1;
					if ("200" == c.state.code) {
						var b = $(".my_purchase_record_" + a.type),
							f = [];
						c.data.topicList ? f = c.data.topicList : c.data.channelGiftList ? f = c.data.channelGiftList : c.data.userDocs ? f = c.data.userDocs : c.data && 0 < c.data.length && (f = c.data);
						c.data && 0 < f.length ? (b.find(".none_record").hide(), b.find(".box_nothing").show(), c = a.html(f), f.length < a.pageSize ? (a.isLoad = !1, b.find(".box_nothing .tips_1").text("\u6ca1\u6709\u66f4\u591a\u5185\u5bb9\u4e86")) : (a.isLoad = !0, b.find(".box_nothing .tips_1").text("\u6b63\u5728\u52a0\u8f7d\u4e2d...")), 0 < b.find("dl").length ? b.find(".list").append(c) : b.find(".list").html(c)) : 0 == b.find("dl ").length ? (b.find(".none_record").show(), b.find(".box_nothing").hide()) : (a.isLoad = !1, b.find(".box_nothing .tips_1").text("\u6ca1\u6709\u66f4\u591a\u5185\u5bb9\u4e86"));
						a.page++
					} else $(document).minTipsBox({
						tipsContent: c.state.msg,
						tipsTime: 1
					})
				},
				error: function() {
					a.fetchRecordLock = !1;
					$(document).minTipsBox({
						tipsContent: "\u7cfb\u7edf\u6545\u969c\uff0c\u7ef4\u62a4\u4e2d",
						tipsTime: 1
					});
					a.isLoad = !0
				}
			}))
		},
		html: function(a) {
			var c = "",
				b;
			for (b in a) c += this.tpl(a[b]);
			return c
		},
		tpl: function(a) {
			if ("doc" === this.type) {
				var c = 1048576 < a.size ? (a.size / 1048576).toFixed(2) + "MB" : (a.size / 1024).toFixed(2) + "KB";
				return '<div class="file-item">  <header class="item-header">  \t<img class="doc-type" src="' + a.icon + '" alt="">  \t<div class="doc-category">  \t\t<span class="doc-name">' + a.name + '</span>  \t\t<span class="doc-size">' + c + '</span>  \t</div>  </header>  <section class="item-content">  \t<span>\u8d2d\u4e70\u65f6\u95f4 ' + a.createTime + '</span>  \t<span class="download_num">\u5df2\u652f\u4ed8\uffe5' + (a.amount / 100).toFixed(2) + "</span>  </section></div>"
			}
			var b = "",
				e = "",
				d = c = "";
			"topic" === this.type ? (b = (a.pic ? a.pic : "https://img.qlchat.com/qlLive/liveCommon/ticket_header.jpg") + "@130h_160w_1e_1c_2o", e = "/topic/" + a.topicId + ".htm", "Y" === a.isGift && (d = 5 < a.sendName.length ? wordFilter(a.sendName.substring(0, 5)) + "..." : wordFilter(a.sendName), d = "Y" === a.isGift ? '<span class="record-gift-tag">\u6765\u81ea' + d + "\u7684\u8d60\u793c</span>" : "")) : "channel" === this.type ? (b = (a.pic ? a.pic : "https://img.qlchat.com/qlLive/liveCommon/channelNormal.png") + "@120h_120w_1e_1c_2o_120-2ci", e = "/live/channel/channelPage/" + a.channelId + ".htm", "Y" === a.isGift && (d = 5 < a.sendName.length ? wordFilter(a.sendName.substring(0, 5)) + "..." : wordFilter(a.sendName), d = "Y" === a.isGift ? '<span class="record-gift-tag">\u6765\u81ea' + d + "\u7684\u8d60\u793c</span>" : ""), a.chargeMonths && 0 < a.chargeMonths && (c = "\u5171\u8d2d\u4e70" + a.chargeMonths + "\u4e2a\u6708&nbsp;&nbsp;")) : "gift" === this.type ? ("topic" === this.giftType && (b = (a.backgroundUrl ? a.backgroundUrl : "https://img.qlchat.com/qlLive/liveCommon/ticket_header.jpg") + "@130h_160w_1e_1c_2o", e = "/live/gift/detail.htm?giftId=" + a.id), "channel" === this.giftType && (b = (a.headImage ? a.headImage : "https://img.qlchat.com/qlLive/liveCommon/ticket_header.jpg") + "@130h_160w_1e_1c_2o", e = "/wechat/page/channel/gift/" + a.id)) : "live" === this.type && (b = (a.headImgUrl ? a.headImgUrl : "https://img.qlchat.com/qlLive/liveCommon/channelNormal.png") + "@120h_120w_1e_1c_2o_10-2ci", e = "/live/" + a.businessId + ".htm", a.money = (a.amount / 100).toFixed(2), a.title = a.name, a.benifit = 0, a.chargeMonths && 0 < a.chargeMonths && (c = "\u5171\u8d2d\u4e70" + a.chargeMonths + "\u4e2a\u6708&nbsp;&nbsp;"));
			var l = this.strFilter(a.title || a.topicName || a.channelName, this.type),
				b = '<dl data-href="' + e + '"><dt class="img"><img src="' + b + '" /></dt><dd class="text"><p>' + l + "</p>";
			a.liveName && (b += "<span>" + a.liveName + "</span>");
			b += '</dd><dd class="bottom">' + d;
			b = "gift" === this.type ? b + ("<p><span>\u6570\u91cf: </span><span>" + a.giftCount + "\u4e2a</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>\u5b9e\u4ed8:</span><span> \u00a5" + a.money / 100 + "</p>") : 0 == a.benifit ? b + ("<p>" + c + " \u5b9e\u4ed8:<span> \u00a5" + a.money + "</span></p>") : b + ("<p>" + c + " \u5b9e\u4ed8:<span> \u00a5" + a.money + "</span>\uff08\u5df2\u4f18\u60e0\u62b5\u6263\u00a5" + a.benifit + "\uff09</p>");
			"gift" === this.type && (b += '<div class="icon"><i class="icon_label"></i>\u8d60\u793c</div>');
			return b += "<time>\u8d2d\u4e70\u65f6\u95f4\uff1a" + (a.time || a.updateTime || a.createTime) + "</time></dd></dl>"
		},
		strFilter: function(a, c) {
			return a ? ("topic" === c || "gift" === c) && 21 <= a.length ? wordFilter(a.substring(0, 21)) + "..." : "channel" === c && 25 <= a.length ? wordFilter(a.substring(0, 25)) + "..." : wordFilter(a) : ""
		}
	};
	0 < $(".my_purchase_record").length && (bR.init(), localStorage && !localStorage.getItem("timelineSpot") && (console.log("object"), $(".tab-timeline").prepend('<span class="newPoint"  style="position: absolute; right: 30%; top: .2rem; display: inline-block; height: .8rem; width: .8rem; border-radius: 5rem; background: #f14a4e;"></span>')));
	var bS = !0,
		da = "";
	if (0 < $("#payPeopleList").length) {
		var bT = 2;
		pageLoadCommon($("#payPeopleList"), Fa)
	}
	var bU = !0,
		Ia = 2,
		da = "";
	0 < $("#memberPage").length && pageLoadCommon($("#memberPage"), Ha);
	$(document).on("keyup", ".member-search-name", function(a) {
		13 == a.keyCode && mb()
	}).on("click", ".member-search-confirm", function() {
		mb()
	});
	$(document).on("click", ".people-manage", function() {
		var a = 0 < $(this).parents(".manage-obj").length ? $(this).parents(".manage-obj") : $(this).parents(".join-list"),
			c = 0 < $(this).parents("li").length ? a.find(".paypeople_img img").attr("src") : a.find(".user_head img").attr("src"),
			a = 0 < $(this).parents("li").length ? a.find(".paypeople_name").html() : a.find(".user_name").html(),
			b = $(this).attr("attr-userid");
		$(".black-options-people .thisImg img").attr("src", c);
		$(".black-options-people .thisName").text(a);
		$(".cancelOrBlack").attr("attr-userid", b);
		$(".tiChu").attr("attr-userid", b);
		a = $(this);
		c = a.attr("attr-istichu");
		a = a.attr("attr-isblack");
		"Y" != c ? ($(".tiChu").attr("attr-blackIt", "Y"), $(".isTichuBox .qlMT_content").show(), $(".isTichuBox .isCancel").html(""), $(".tiChu span").text("\u8e22\u51fa")) : ($(".tiChu").attr("attr-blackIt", "N"), $(".isTichuBox .qlMT_content").hide(), $(".isTichuBox .isCancel").html("\u53d6\u6d88"), $(".tiChu span").text("\u53d6\u6d88\u8e22\u51fa"));
		"Y" != a ? ($(".addBlack").attr("attr-blackIt", "Y"), $(".isBlackBox .qlMT_content").show(), $(".isBlackBox .isCancel").html("\u52a0\u5165"), $(".addBlack span").text("\u52a0\u5165\u9ed1\u540d\u5355")) : ($(".addBlack").attr("attr-blackIt", "N"), $(".isBlackBox .qlMT_content").hide(), $(".isBlackBox .isCancel").html("\u53d6\u6d88"), $(".addBlack span").text("\u53d6\u6d88\u9ed1\u540d\u5355"));
		showBottomBox("#black-options")
	});
	$(document).on("click", ".member-search-btn", function() {
		$(this).hide();
		$(".search-focus-box").show().find(".member-search-name").focus()
	}).on("click", ".search-focus-box .member-search-cancel", function() {
		$(".search-focus-box").hide();
		$(".member-search-btn").show()
	});
	$(document).on("click", ".cancelOrBlack", function() {
		0 < $(".blackListPage").length ? ($(".thisNameS").text($(this).parents(".manage-obj").find(".paypeople_name").text()), $(".isBlackBox .tlbtn_confirm").attr("attr-userid", $(this).attr("attr-userid")), $(".isBlackBox .tlbtn_confirm").attr("attr-blackIt", $(this).attr("attr-blackIt"))) : $(".thisNameS").text($(".black-options-people .thisName").text());
		qlSlBoxShow(".isBlackBox")
	}).on("click", ".isBlackBox .tlbtn_confirm", function() {
		var a = 0 < $(".blackListPage").length ? {
			liveId: liveId,
			status: $(this).attr("attr-blackIt"),
			userId: $(this).attr("attr-userid")
		} : {
			liveId: liveId,
			status: $(".cancelOrBlack").attr("attr-blackIt"),
			userId: $(".cancelOrBlack").attr("attr-userid")
		};
		blackFunc(a);
		$(".isBlackBox").hide();
		hideBottomBox("#black-options")
	});
	$(document).on("click", ".tiChu", function() {
		$(".thisNameS").text($(".black-options-people .thisName").text());
		"Y" === $(this).attr("attr-blackit") ? qlSlBoxShow(".isTichuBox") : qlSlBoxShow(".isCancelTichuBox")
	}).on("click", ".isTichuBox .tlbtn_confirm", function() {
		var a = "topic" == manageType ? {
			businessId: topicId,
			type: "topic",
			status: $(".tiChu").attr("attr-blackIt"),
			userId: $(".tiChu").attr("attr-userid")
		} : {
			businessId: channelId,
			type: "channel",
			status: $(".tiChu").attr("attr-blackIt"),
			userId: $(".tiChu").attr("attr-userid")
		};
		Ja(a);
		$(".isTichuBox").hide();
		hideBottomBox("#black-options")
	}).on("click", ".isCancelTichuBox .tlbtn_confirm", function() {
		var a = "topic" == manageType ? {
			businessId: topicId,
			type: "topic",
			isDelete: "N",
			status: $(".tiChu").attr("attr-blackIt"),
			userId: $(".tiChu").attr("attr-userid")
		} : {
			businessId: channelId,
			type: "channel",
			isDelete: "N",
			status: $(".tiChu").attr("attr-blackIt"),
			userId: $(".tiChu").attr("attr-userid")
		};
		Ja(a);
		$(".isCancelTichuBox").hide();
		hideBottomBox("#black-options")
	}).on("click", ".isCancelTichuBox .tlbtn_cancel", function() {
		var a = "topic" == manageType ? {
			businessId: topicId,
			type: "topic",
			isDelete: "Y",
			status: $(".tiChu").attr("attr-blackIt"),
			userId: $(".tiChu").attr("attr-userid")
		} : {
			businessId: channelId,
			type: "channel",
			isDelete: "Y",
			status: $(".tiChu").attr("attr-blackIt"),
			userId: $(".tiChu").attr("attr-userid")
		};
		Ja(a);
		$(".isCancelTichuBox").hide();
		hideBottomBox("#black-options")
	}).on("click", ".isCancelTichuBox .bg-shadow", function() {
		$(".isCancelTichuBox").hide()
	});
	if (0 < $(".DatasListBox").length) {
		var w = 1,
			v = !0,
			O = 20;
		nb()
	}
	0 < $("#history-people-box").length && (w = 1, v = !0, O = 20, ob(), $(document).on("click", ".historyLoadMore", function() {
		ob()
	}))
});
window.angular && !
function() {
	angular.module("GiftDetail", []).controller("GiftDetailController", ["$scope", function(b) {
		function h() {
			b.hasNext && $.ajax({
				url: "/live/gift/users.htm",
				data: {
					giftId: b.giftId,
					pageNum: b.pageCtrl.pageNum,
					pageSize: b.pageCtrl.pageSize
				},
				success: function(h) {
					200 === h.state.code && (b.pageCtrl.pageNum += 1, b.$apply(function() {
						0 === h.data.length && (b.hasNext = !1);
						b.list = b.list.concat(h.data)
					}))
				}
			})
		}
		b.giftId = window.giftId;
		b.giftCount = window.giftCount;
		b.giftMoney = window.giftMoney;
		b.money = window.money;
		b.overTime = window.overTime;
		b.topicName = window.topicName;
		b.speaker = window.speaker;
		b.startTime = window.startTime;
		b.isBeGet = window.isBeGet;
		b.type = window.type;
		b.hasNext = !0;
		b.pageCtrl = {
			pageNum: 1,
			pageSize: 5
		};
		b.list = [];
		b.redirect = function(b, d) {
			"app" == getCookie("caller") ? appSdk.linkTo(d ? "dl/live/topic/introduce?topicId=" + b : "dl/live/topic?topicId=" + b) : location.href = d ? "/topic/" + b + ".htm" : "/topic/" + b + ".htm?preview=Y&intoPreview=Y"
		};
		b.goWebpage = function(b, d) {
			d && ("app" == getCookie("caller") ? appSdk.goWebPage(b) : location.href = b)
		};
		pageLoadCommon($(".GiftDetail"), h);
		h()
	}])
}();

function blackFunc(b) {
	$.ajax({
		type: "POST",
		url: "/live/entity/addBlackList.htm",
		data: b,
		success: function(h) {
			"200" === h.statusCode ? "Y" == b.status ? ($(".people-manage[attr-userid='" + b.userId + "']").attr("attr-isblack", "Y"), $(".manage-obj[attr-userid='" + b.userId + "']").find(".paypeople_status2").show(), alertMsg("\u6210\u529f\u628a\u6b64\u4eba\u52a0\u5165\u9ed1\u540d\u5355", 1)) : ($(".people-manage[attr-userid='" + b.userId + "']").attr("attr-isblack", "N"), $(".manage-obj[attr-userid='" + b.userId + "']").find(".paypeople_status2").hide(), alertMsg("\u6210\u529f\u53d6\u6d88\u52a0\u5165\u9ed1\u540d\u5355", 1), 0 < $(".blackListPage").length && $(".cancelOrBlack[attr-userid='" + b.userId + "']").parents("li").remove()) : alertMsg(h.msg, 1)
		}
	})
}
function blackLoadFunc() {
	loadingBol && (loadingBol = !1, $.ajax({
		type: "POST",
		url: "/live/entity/blacklist.htm",
		data: {
			liveId: liveId,
			page: pageNum,
			pageSize: pageSize
		},
		success: function(b) {
			$(".page_loading_box").hide();
			if ("200" == b.statusCode) {
				b = b.data;
				var h = template("tpl-item-list", {
					data: b
				});
				1 == pageNum ? ($(".blackListBox").html(h), pageLoadCommon($("#loadPage"), blackLoadFunc, 100)) : $(".blackListBox").append(h);
				1 == pageNum && 1 > b.length ? $(".none_record").show() : (b.length < pageSize ? $("#loadNone").show() : loadingBol = !0, pageNum++)
			} else loadingBol = !0, alertMsg(b.msg, 1)
		}
	}))
}
$(document).on("click", ".channel-tabbar a", function() {
	$(this).addClass("active").siblings("a").removeClass("active");
	var b = $(this).attr("name");
	$(".channel-post").hide();
	$(".channel-" + b).show();
	0 >= $(".channel-intro img").length && $.ajax({
		url: "/live/channel/profile/get.htm",
		type: "POST",
		data: {
			channelId: channelId
		},
		success: function(b) {
			200 === b.state.code ? (0 < b.data.length && (b = template("tpl-introimg-list", {
				data: b.data
			}), $(".channel-intro article").append(b)), 0 >= $(".channel-intro p").length ? ($(".gaiyao").hide(), $(".none-gaiyao").show()) : $(".gaiyao").show()) : alertMsg(b.state.msg);
			$(".loadingBox").hide()
		},
		error: function(b) {
			b && b.state && b.state.msg && alertMsg(b.state.msg);
			$(".loadingBox").hide()
		}
	})
});
!
function() {
	angular.module("LiveApp", []).controller("LiveIndexController", ["$scope", "$http", function(b, h) {
		function q(p) {
			b.loadingList = !1;
			b.noMore = !1;
			u = b.noChannel = !1;
			L.hide();
			b.tabs = b.tabs.map(function(e, d) {
				d === p ? (e.isActive = !0, b.currentTab = e.tag) : e.isActive = !1;
				return e
			});
			b.channelList = [];
			b.topicList = [];
			"topic" === b.currentTab ? (b.topicPage.page = 1, d(!0)) : "channel" === b.currentTab ? (b.channelPage.page = 1, E(), E(null, !0)) : (b.loadingList = !1, b.noMore = !1, b.noChannel = !1)
		}
		function d(d) {
			b.loadingList = !0;
			d && (b.channelPage.page = 1, b.topicList = []);
			h.get("/live/getTopics.htm", {
				params: {
					liveId: liveId,
					page: b.topicPage.page,
					pageSize: b.topicPage.size
				}
			}).then(function(e) {
				e = e.data;
				b.loadingList = !1;
				200 === e.state.code && "topic" === b.currentTab && (e.data.liveTopics ? (e = e.data.liveTopics.map(function(b) {
					b.isgoing = currentTimeMillis >= b.startTimeStamp ? "Y" : "N";
					b.backgroundUrl && (b.backgroundUrl += "@180h_272w_1e_1c_2o");
					return b
				}), b.topicPage.page += 1, S(e), d ? (b.noChannel = 0 === e.length, b.topicList = e) : b.topicList = b.topicList.concat(e), b.noMore = e < b.topicPage.size, u = e < b.topicPage.size) : (u = b.noMore = !0, b.noChannel = !0))
			}, function(e) {
				console.error(e);
				b.loadingList = !1
			})
		}
		function S(d) {
			d = d.filter(function(b) {
				return "charge" == b.type
			});
			d = d.map(function(b) {
				return b.id
			}).join(",");
			h.get("/live/topic/getScoreByTopicId.htm", {
				params: {
					topicIdList: d
				}
			}).then(function(e) {
				200 == e.statusCode && e.data && e.data.topicList && e.data.topicList.length && e.data.topicList.forEach(function(e) {
					b.topicList.forEach(function(b) {
						b.id == e.topicId && (b.score = e.score, b.starWidthByScore = [], 0 < e.score && [1, 2, 3, 4, 5].forEach(function(d) {
							b.starWidthByScore.push({
								percent: K(d, e.score)
							})
						}))
					})
				})
			})
		}
		function C(d, e, l) {
			b.loadingList = !0;
			e && (b.channelPage.page = 1, b.channelList = []);
			h.get("/live/getChannels.htm", {
				params: {
					liveId: liveId,
					page: b.channelPage.page,
					pageSize: b.channelPage.size,
					tagId: d
				}
			}).then(function(d) {
				d = d.data;
				b.loadingList = !1;
				200 === d.state.code && "channel" === b.currentTab && (e ? (b.channelList = d.data, l && l(), b.noChannel = 0 === b.channelList.length) : b.channelList = b.channelList.concat(d.data), b.noMore = 1 != b.channelPage.page && d.data < b.channelPage.size, u = d.data < b.channelPage.size, b.channelPage.page += 1, va(d.data))
			}, function(e) {
				console.error(e);
				b.loadingList = !1
			})
		}
		function va(d) {
			d = d.filter(function(b) {
				return b.chargeConfigs[0] && 0 < b.chargeConfigs[0].amount
			});
			d = d.map(function(b) {
				return b.id
			}).join(",");
			h.get("/live/channel/getScoreByChannelId.htm", {
				params: {
					channelIdList: d
				}
			}).then(function(e) {
				200 == e.statusCode && e.data.channelList.length && e.data.channelList.forEach(function(e) {
					b.channelList.forEach(function(b) {
						b.id == e.channelId && (b.score = e.score, b.starWidthByScore = [], 0 < e.score && [1, 2, 3, 4, 5].forEach(function(d) {
							b.starWidthByScore.push({
								percent: K(d, e.score)
							})
						}))
					})
				})
			})
		}
		function K(b, e) {
			e = e.toString();
			var d = e.split(".")[0],
				h = e.split(".")[1];
			return (d >= b ? 100 : h && Math.ceil(e) == b ? parseInt(100 * ("0." + h)) : 0) + "%"
		}
		function E(d, e) {
			e || (b.loadingList = !0);
			
		}
		b.currentTab = "topic";
		b.loadingList = !1;
		var u = b.noMore = !1;
		b.noChannel = !1;
		var V = sessionStorage.getItem("activeLiveIndexTab");
		window.activeChannelTypes = sessionStorage.getItem("activeChannelType") && JSON.parse(sessionStorage.getItem("activeChannelType"));
		b.channelPage = {
			page: 2,
			size: 20
		};
		b.topicPage = {
			page: 1,
			size: 20
		};
		b.tabs = [{
			tag: "topic",
			title: "\u8bdd\u9898",
			isActive: !0
		}, {
			tag: "channel",
			title: "\u7cfb\u5217\u8bfe",
			isActive: !1
		}, {
			tag: "intro",
			title: "\u4ecb\u7ecd",
			isActive: !1
		}];
		b.channelTypes = null;
		b.channelList = [];
		b.topicList = [];
		b.onTabClick = q;
		b.onScrollItemClick = function(d) {
			var e = 0;
			b.channelTypes.forEach(function(b, h) {
				h === d ? (e = b.id, b.isActive = !0, b.isSelected = !0, window.activeChannelTypes = b, sessionStorage.setItem("activeChannelType", JSON.stringify(b))) : (b.isActive = !1, b.isSelected = !1)
			});
			b.allChannelTypes.forEach(function(e) {
				e.isSelected = e.id == b.channelTypes[d].id ? !0 : !1
			});
			b.noMore = !1;
			b.noChannel = !1;
			b.loadingList = !0;
			b.channelPage.page = 1;
			u = !1;
			C(e, !0)
		};
		b.popTypeChooser = function() {
			0 === b.allChannelTypes.length ? alertMsg("\u6ca1\u6709\u521b\u5efa\u7cfb\u5217\u8bfe\u5206\u7c7b", 1) : qlSlBoxShow("#channelTypeChooser")
		};
		b.hideChannel = function(d) {
			h.get("/live/channel/changeDisplay.htm", {
				params: {
					channelId: b.channelList[b.activeChannelIndex].id,
					display: "hide" == d ? "N" : "Y",
					tagId: window.activeChannelTypes ? window.activeChannelTypes.id : 0
				}
			}).then(function(e) {
				200 === e.data.state.code && (b.activeChannel.displayStatus = "hide" == d ? "N" : "Y", alertMsg("\u64cd\u4f5c\u6210\u529f", 1), hideBottomBox("#channel-options"))
			})
		};
		b.closeQrcode = function() {
			$(".popQrBox").hide()
		};
		b.popQrCode = function() {
			qlSlBoxShow(".popQrBox")
		};
		b.linkToChannel = function(b, d) {
			$((b || void 0).target).hasClass("channel_settings") || (sessionStorage.setItem("activeLiveIndexTab", "channel"), window.location.href = "/live/channel/channelPage/" + d + ".htm")
		};
		b.linkToTopic = function(b, d) {
			var e = b || e;
			$(e.target).hasClass("topic-settings") || $(e.target).hasClass("icon_control3 ") || (sessionStorage.setItem("activeLiveIndexTab", "topic"), sessionStorage.setItem("activeTopicId", d), window.location.href = "/topic/" + d + ".htm?preview=Y&intoPreview=Y")
		};
		b.selectItem = function(d) {
			b.allChannelTypes.forEach(function(b, h) {
				b.isSelected = d === h
			})
		};
		b.confirmSelect = function() {
			var d = b.allChannelTypes.filter(function(b) {
				return b.isSelected
			})[0];
			window.activeChannelTypes && d.id == window.activeChannelTypes.id ? (alertMsg("\u64cd\u4f5c\u6210\u529f"), $("#channelTypeChooser").hide()) : (sessionStorage.setItem("activeChannelType", JSON.stringify(d)), h.get("/live/channel/moveChannelIntoTag.htm", {
				params: {
					channelId: b.channelList[b.activeChannelIndex].id,
					tagId: d.id
				}
			}).then(function(b) {
				b = b.data;
				200 === b.state.code && (alertMsg(b.state.msg), $("#channelTypeChooser").hide(), window.location.reload())
			}))
		};
		b.onPopSetting = function(d) {
			b.activeChannelIndex = d;
			b.activeChannel = window.activeChannel = b.channelList[b.activeChannelIndex];
			b.currentTitle = window.activeChannel.name
		};
		b.linkTo = function(b) {
			window.location.href = b
		};
		b.popTopicSettings = function(d) {
			b.activeTopicIndex = d;
			b.activeTopic = window.activeTopic = b.topicList[b.activeTopicIndex];
			b.currentTopicTitle = window.activeTopic.topic
		};
		var a = $(".co-tabs"),
			L = $("#fixedTabBar"),
			M = 0;
		setTimeout(function() {
			M = a.height()
		}, 100);
		var c = $("#content");
		pageLoadCommon($("#QLLiveRoom"), function() {
			b.loadingList || b.noMore || u || ("channel" === b.currentTab ? C(window.activeChannelTypes && window.activeChannelTypes.id, !1) : "topic" === b.currentTab && d())
		});
		"channel" === V ? (b.currentTab = "channel", q(1)) : 0 == topicNum && 0 != channelNum ? (b.currentTab = "channel", q(1)) : (b.currentTab = "topic", q(0));
		(function() {
			$("#QLLiveRoom").on("scroll", function(b) {
				c.offset().top < M ? L.show() : L.hide()
			})
		})()
	}]).controller("ChannelTypesController", ["$scope", "$http", function(b, h) {
		b.types = [];
		b.popMenus = {
			show: !1,
			inTop: !1,
			inBottom: !1
		};
		b.loading = !1;
		b.activeIndex = 0;
		var q = $(document.body).height();
		b.onPopOption = function(d, h) {
			b.popMenus.show || (b.activeIndex = h, d = $((d || void 0).target).offset().top, d > q / 2 ? ($(".pop_menus ul").css({
				bottom: q - d + "px",
				top: "auto"
			}), b.popMenus.inTop = !0, b.popMenus.inBottom = !1) : ($(".pop_menus ul").css({
				top: d + 30 + "px",
				bottom: "auto"
			}), b.popMenus.inTop = !1, b.popMenus.inBottom = !0), b.popMenus.show = !0)
		};
		b.closePopOption = function() {
			b.popMenus.show = !1
		};
		b.popEdit = function() {
			qlSlBoxShow("#typesEdit");
			b.changeType = b.types[b.activeIndex].name;
			b.popMenus.show = !1
		};
		b.popUp = function() {
			0 !== b.activeIndex && h.get("/live/channel/moveChannelTag.htm", {
				params: {
					id: b.types[b.activeIndex].id,
					type: "up"
				}
			}).then(function(d) {
				d = d.data;
				200 === d.state.code ? (alertMsg(d.state.msg, 1), d = b.types[b.activeIndex - 1], b.types[b.activeIndex - 1] = b.types[b.activeIndex], b.types[b.activeIndex] = d, b.popMenus.show = !1) : alertMsg(d.state.msg, 1)
			}, function(b) {
				console.error(b)
			})
		};
		b.popDown = function() {
			b.activeIndex !== b.types.length - 1 && h.get("/live/channel/moveChannelTag.htm", {
				params: {
					id: b.types[b.activeIndex].id,
					type: "down"
				}
			}).then(function(d) {
				d = d.data;
				200 === d.state.code ? (alertMsg(d.state.msg, 1), d = b.types[b.activeIndex + 1], b.types[b.activeIndex + 1] = b.types[b.activeIndex], b.types[b.activeIndex] = d, b.popMenus.show = !1) : alertMsg(d.state.msg, 1)
			}, function(b) {
				console.error(b)
			})
		};
		b.popDelete = function() {
			qlSlBoxShow("#shouldDelete");
			b.popMenus.show = !1
		};
		b.onCancel = function(b, h) {
			$((b || void 0).target).parents(".qlMsgTips").hide()
		};
		b.popNewType = function() {
			10 <= b.types.length ? alertMsg("\u6700\u591a\u53ea\u80fd\u521b\u5efa10\u4e2a\u5206\u7c7b") : qlSlBoxShow("#typesAdd")
		};
		b.doDelete = function() {
			$("#shouldDelete").hide();
			h.get("/live/channel/deleteChannelTag.htm", {
				params: {
					id: b.types[b.activeIndex].id
				}
			}).then(function(d) {
				d = d.data;
				200 === d.state.code ? (alertMsg(d.state.msg, 1), $("#shouldDelete").hide(), b.types[b.activeIndex].name = b.changeType, b.types = b.types.filter(function(d) {
					return d.id !== b.types[b.activeIndex].id
				})) : alertMsg(d.state.msg, 1)
			}, function(b) {
				console.error(b)
			})
		};
		b.doAdd = function() {
			b.loading || (10 < b.newType.length ? alertMsg("\u5206\u7c7b\u540d\u79f0\u4e0d\u80fd\u8d85\u8fc710\u4e2a\u5b57", 1) : "" == b.newType ? alertMsg("\u5206\u7c7b\u540d\u79f0\u4e0d\u80fd\u4e3a\u7a7a", 1) : (b.loading = !0, h.post("/live/channel/addOrEditChannelTag.htm", {
				data: {
					liveId: liveId,
					name: b.newType
				}
			}).then(function(d) {
				d = d.data;
				b.newType = "";
				200 === d.state.code ? (alertMsg(d.state.msg, 1), $("#typesAdd").hide(), b.types.push(d.data)) : alertMsg(d.state.msg, 1);
				b.loading = !1
			}, function(d) {
				b.loading = !1;
				console.error(d)
			})))
		};
		b.doEdit = function() {
			b.loading || (10 < b.changeType.length ? alertMsg("\u5206\u7c7b\u540d\u79f0\u4e0d\u80fd\u8d85\u8fc710\u4e2a\u5b57", 1) : 10 < b.changeType.length ? alertMsg("\u5206\u7c7b\u540d\u79f0\u4e0d\u80fd\u8d85\u8fc710\u4e2a\u5b57", 1) : "" == b.changeType ? alertMsg("\u5206\u7c7b\u540d\u79f0\u4e0d\u80fd\u4e3a\u7a7a", 1) : (b.loading = !0, h.post("/live/channel/addOrEditChannelTag.htm", {
				data: {
					id: b.types[b.activeIndex].id,
					liveId: liveId,
					name: b.changeType
				}
			}).then(function(d) {
				d = d.data;
				200 === d.state.code ? (alertMsg(d.state.msg, 1), $("#typesEdit").hide(), b.types[b.activeIndex].name = b.changeType) : alertMsg(d.state.msg, 1);
				b.loading = !1
			}, function(d) {
				b.loading = !1;
				console.error(d)
			})))
		};
		(function() {
			
		})()
	}]).filter("peopleNum", function() {
		return function(b) {
			b = Number(b);
			return 9999 < b ? (b / 1E4).toFixed(1) + "\u4e07" : b
		}
	})
}();