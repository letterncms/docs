import { invalidate as e, plural as t, registry as n, t as r, useAbility as i } from "@letterncms/sdk";
import { Widget as a, WidgetRow as o } from "@letterncms/ui";
import { useEffect as s } from "react";
import { jsx as c, jsxs as l } from "react/jsx-runtime";
// admin/src/index.tsx
function u({ entry: n }) {
	let a = i("reading-time/estimate", { id: n?.id ?? "" }, { enabled: !!n });
	return s(() => e("reading-time/"), [n?.updatedAt]), !n || !a.data ? null : /* @__PURE__ */ l("div", {
		className: "p-4 text-sm text-text",
		children: [/* @__PURE__ */ c("p", {
			className: "m-0 text-2xl font-semibold text-ink",
			children: r("{minutes} min", { minutes: a.data.minutes })
		}), /* @__PURE__ */ c("p", {
			className: "m-0 mt-1 text-muted",
			children: t(a.data.words, "{count} word", "{count} words")
		})]
	});
}
n.panels.set("reading-time", {
	id: "reading-time",
	slot: "entry.sidebar",
	label: r("Reading time"),
	icon: "clock",
	component: u
});
function d() {
	let e = i("reading-time/longest", { limit: 5 }), t = e.data?.average;
	return /* @__PURE__ */ c(a, {
		query: e,
		action: t != null && /* @__PURE__ */ c("span", {
			className: "text-xs text-faint",
			children: r("{minutes} min on average", { minutes: t })
		}),
		empty: e.data?.entries.length === 0 && {
			icon: "clock",
			title: r("Nothing published yet")
		},
		children: e.data?.entries.map((e) => /* @__PURE__ */ c(o, {
			to: `/content/${e.collection}/${e.id}`,
			icon: "file-text",
			title: e.title,
			meta: r("{minutes} min", { minutes: e.minutes })
		}, e.id))
	});
}
n.widgets.set("reading-time-longest", d);
