create table pay_terminal(
 `id` bigint unsigned NOT NULL,
 `name` varchar(25) NOT NULL DEFAULT "" COMMENT "名称",
 `access_token` char(32) NOT NULL DEFAULT "" COMMENT "令牌",
 `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 primary key (`id`)
)engine=InnoDB DEFAULT charset=utf8 COMMENT "终端信息表";

create table pay_trace(
 `id` int unsigned NOT NULL,
 `terminal_id` int unsigned NOT NULL DEFAULT 0 COMMENT "终端号",
 `url` varchar(150) NOT NULL DEFAULT "" COMMENT "请求地址",
 `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 primary key (`id`)
)engine=InnoDB DEFAULT charset=utf8 COMMENT "流水表";

create table pay_order(
 `id` int unsigned NOT NULL,
 `terminal_id` int unsigned NOT NULL DEFAULT 0 COMMENT "终端号",
 `terminal_trace` varchar(32) NOT NULL DEFAULT "" COMMENT "终端流水号",
 `total_fee` int NOT NULL DEFAULT 0 COMMENT "金额，单位分",
 `status` tinyint NOT NULL DEFAULT 1 COMMENT "订单状态->1:未支付,2:已支付",
 `out_trade_no` varchar(32) NOT NULL DEFAULT "" COMMENT "利楚唯一订单号",
 `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 primary key (`id`),
 key `out_trade_no` (`out_trade_no`) USING BTREE
)engine=InnoDB DEFAULT charset=utf8 COMMENT "订单表";

create table pay_refund(
 `id` int unsigned NOT NULL,
 `terminal_id` int unsigned NOT NULL DEFAULT 0 COMMENT "终端号",
 `terminal_trace` char(32) NOT NULL DEFAULT "" COMMENT "终端流水号",
 `out_trade_no` char(32) NOT NULL DEFAULT "" COMMENT "利楚唯一订单号",
 `refund_fee` int NOT NULL DEFAULT 0 COMMENT "退款金额，单位分",
 `status` tinyint NOT NULL DEFAULT 1 COMMENT "退款状态->1:未退款,2:已退款",
 `out_refund_no` char(32) NOT NULL DEFAULT "" COMMENT "利楚唯一退款单号",
 `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 primary key (`id`)
)engine=InnoDB DEFAULT charset=utf8 COMMENT "退款表";
