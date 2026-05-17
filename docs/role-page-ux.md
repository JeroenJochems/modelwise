# Role Page UX — Proposal

**Author:** Jeroen · **Date:** 2026-05-17 · **Scope:** `/roles/{role}` (Show.tsx + ApplicationStatus + ExtendedApplicationForm)

## What's wrong today

The page is doing two jobs at once and fighting itself:

1. **Describe the opportunity** (fee, brand, shoot dates, look-and-feel)
2. **Walk the model through one of 7 states** (not-applied / passed / applied / shortlisted / extended / hired / rejected)

It tries to solve this with **two tabs**: "Your application" + "Job details." The tabs hide whichever half isn't selected, which means:

- Pre-apply users never see "Your application" (it's hidden via `hasApplied` check). The TabList just disappears. Layout shifts.
- Applied users land on "Your application" first. They have to switch tabs to read the brief again.
- Shortlisted users see a long stacked form (briefing PDFs → photos → video → submit) competing for attention with the entire job description hidden behind a tab.
- The actionable state never bubbles up: a shortlisted model with unfinished work sees no hint of it on the role card or page header. They have to remember to open the role and click the right tab.

### Specific failures, per state

| State | What user sees | What's broken |
|---|---|---|
| **Not applied** | JobHeader → "Job details" tab body → sticky "I'm interested / Pass" footer | Hero is a title only — no photo, no fee, no dates. Critical decision-making info lives below the fold. |
| **Passed** | Same layout. Footer says "You have passed on this role." | No way to un-pass except via the same footer link — it's not labeled as "change mind." Looks terminal. |
| **Applied (pending)** | "Your application" tab shows only "Thank you for applying. We'll get back to you." | Wasted real estate. No timeline, no expectation, no "what to do next." |
| **Shortlisted** | "You've been shortlisted" + ExtendedApplicationForm — 3-section stacked form, generic "Submit" at the bottom. | (a) No sense of progress. (b) No required-vs-optional indication. (c) Submit isn't gated by what's required — user can submit half-completed. (d) "Briefing documents" is a quiet list, easy to miss. (e) Job details hidden in the other tab — model can't re-read the brief while filling the form. (f) No "save draft" — every page nav loses state. |
| **Extended applied (waiting)** | "Waiting for the client response." Static paragraph. | No expected date, no "they viewed your application" signal, no path to update what you sent. |
| **Hired** | "Congratulations! You've been hired." (one line) | No contract details, no next steps, no contact info, no calendar invite, no payment expectation. |
| **Rejected** | "Sorry, you were not hired for this role." | No "browse similar roles" link, no model coaching, no notification preferences. Dead-end. |

### Mobile-specific failures

- 6-slot file uploaders in a 3-col grid make the form 4+ screens tall.
- Submit button is at the bottom of the scroll. With a mobile keyboard up it disappears.
- No status badge in the model's role list — they can't see at a glance which roles need their attention.
- Briefing PDF links open in a new tab — context lost on iOS.

---

## Proposal: state-led, single column, no tabs

Drop the tabs. Stop hiding things. Replace the structure with a single scrollable page that **leads with status** and **always shows the brief**.

### Anatomy

```
┌───────────────────────────────────────────┐
│  HERO                                     │
│  ┌──────────────────────────────────────┐ │
│  │  edge-to-edge look-and-feel photo    │ │
│  │  (job.look_and_feel_photos[0])       │ │
│  └──────────────────────────────────────┘ │
│  Brand · Role title                       │
│  Big H1 — role.name                       │
│  Fee · Shoot date · Location  (3-up)      │
├───────────────────────────────────────────┤
│  STATUS STRIP  (colored, one line)        │
│  "You're shortlisted. 2 steps left."      │
│  → scrolls to action area                 │
├───────────────────────────────────────────┤
│  ACTION AREA  (only when state needs it)  │
│  - State-specific. See per-state designs. │
├───────────────────────────────────────────┤
│  THE BRIEF  (always visible, accordion)   │
│  ▸ Description                            │
│  ▸ Fee & usage                            │
│  ▸ Look & feel photos                     │
│  ▸ About the brand                        │
│  ▸ Documents                              │
├───────────────────────────────────────────┤
│  STICKY FOOTER  (state-aware)             │
│  Not-applied: [I'm interested] [Pass]     │
│  Shortlisted: [Send to client] (disabled  │
│                until required items done) │
│  Other:       hidden                      │
└───────────────────────────────────────────┘
```

The brief is **always one tap away** — no tabs. The action area expands/collapses based on state but never hides the brief.

### Status strip — the spine of the page

A single colored 1-line strip that changes per state:

| State | Color | Copy | Action |
|---|---|---|---|
| Not applied | neutral | "Open for applications until {deadline}." | none |
| Passed | gray | "You passed on this role." | "Change mind →" |
| Applied | blue | "Application sent {date_ago}. Expect a response by {expected_response_at}." | none |
| Shortlisted | amber | "You're shortlisted. {n} steps to send." | "Go to steps →" |
| Extended applied | blue | "Sent to client. Decision expected by {date}." | none |
| Hired | green | "You're hired. Shoot starts {date}." | "Open contract →" |
| Rejected | gray | "Not selected this time." | "Browse similar roles →" |

Pulling the state into a single visible bar means a model who lands on this page knows in one glance what's happening and what they're supposed to do.

### Action area, per state

#### Shortlisted (the heavy one — replaces ExtendedApplicationForm)

A **checklist with inline affordances**, not a stacked form.

```
You're shortlisted for "{role.name}"

The client needs more before they decide. Three quick things:

  ┌──────────────────────────────────────────────┐
  │ ① Read the briefing                          │
  │   • SmartLogger ModBus Interface.pdf  [↓]    │
  │   ☐ I've reviewed the brief                  │
  └──────────────────────────────────────────────┘
  ┌──────────────────────────────────────────────┐
  │ ② Casting photos                  3/3 ✓      │
  │   [thumb] [thumb] [thumb] [+]                │
  │   Specific instructions from the role        │
  │   appear here.                               │
  └──────────────────────────────────────────────┘
  ┌──────────────────────────────────────────────┐
  │ ③ Casting video                  Processing… │
  │   [thumb playing]            [Replace] [×]   │
  │   "Read this 1-line script aloud, look       │
  │    at the camera."                           │
  └──────────────────────────────────────────────┘

  ─────────────────────────────────────────────
  [Send to client]                  disabled
  Submits 3 photos + 1 video. You can replace
  them later if the client hasn't reviewed yet.
```

Key changes vs today:

- Numbered steps with state at the row level (`3/3 ✓`, `Processing…`).
- Required items have a satisfied/unsatisfied state. The CTA stays disabled until all required boxes are green.
- "Briefing" is *step one*, not a footnote.
- Inline instructions per step (we already capture `casting_photo_instructions` / `casting_video_instructions` — surface them next to the uploader, not as a generic paragraph at the top).
- The CTA reads `Send to client` not `Submit`. Active voice, names the destination.
- A one-line summary under the CTA: "Submits 3 photos + 1 video." So the model knows exactly what they're sending.
- "You can replace them later" — implicit reassurance that mistakes are recoverable. (This is true given our new Mux Direct Upload + draft row system.)

#### Applied (pending)

Today: "Thank you for applying."

Replace with a **timeline strip**:

```
  Application sent
  ●─────────○─────────○─────────○
  May 17    Reviewing   Shortlisted   Decision
  ✓                                   expected
                                      by May 24

  We'll email you the moment something changes.
  In the meantime: [Browse similar roles →]
```

Cheap to implement (the dates are already on `listing`), and replaces dead air with momentum.

#### Hired

Today: 1 line of celebration.

Replace with:

```
  🎉 You're hired

  Shoot: Mode 3 — Ethical AI
  Date:  Jun 14, 2026 · 09:00 – 17:00
  Where: Amsterdam, Studio X
  Fee:   €1,200 + €400 buyout

  ┌──────────────────────────────┐
  │  [📄 Contract & call sheet]  │
  │  [📅 Add to calendar]        │
  │  [✉ Contact production]      │
  └──────────────────────────────┘

  What now?
  • Confirm your sizes are still accurate → [link]
  • Production will email a call sheet 48h before
  • Questions? Reply to your booking email.
```

#### Rejected

Today: 1 line of bad news.

Replace with:

```
  Not selected this time

  The client picked someone else. It happens —
  shortlists are usually 5+ models for 1 spot.

  Three things you can do:

  →  Browse 12 open roles for your profile
  →  Refresh your portfolio — your last photo
     was added 7 months ago
  →  See examples of the strongest applications
     in your category (1-min read)
```

Each rejection is a moment of high engagement — capitalize on it.

#### Not applied

Today: title-only header + tab content.

Replace hero with:
- Full-bleed `look_and_feel_photos[0]` (or `public_photos[0]`)
- Overlay: brand logo + role title
- Below: 3-up fact strip (Fee · Date · Location)
- Below that: a short, scannable description (3-line clamp, "Read more" expands)
- Then sticky footer with **"I'm interested"** (primary) + **"Pass"** (secondary)

Most models scan a feed of roles and decide in 5 seconds. The current layout makes that hard because the visual evidence (look-and-feel photos) is buried.

### Always-visible Brief (accordion)

Below the action area, always:

```
The brief
─────────
▸ What the shoot is  (Description)
▸ Fee & usage         (Fee + buyout + buyout_note)
▸ Look & feel          (job.look_and_feel_photos carousel)
▸ Examples for this role (role.public_photos carousel)
▸ About the brand     (brand description + logo)
▸ Documents           (PDFs)
```

Each row is collapsed by default except "What the shoot is" which is open. Saves vertical space, lets the model open exactly what they need.

The shortlisted user fills the form **and** can re-read the brief in the same scroll. No tab switching.

---

## State badges in the role list (out-of-page but related)

On the model's dashboard, each role card should show a status pill:

```
  [Hero photo]
  Brand · Role name
  €1,200 + €400 buyout · Jun 14, Amsterdam

  ●  Shortlisted — 2 steps left      ← amber pill
```

So "things waiting on me" is discoverable without opening each role. Likely a single line on the existing card; copy & color rules mirror the strip above.

---

## What this gets us

- **Pre-apply**: faster yes/no decision (hero photo, fee, dates at the top, brief always open).
- **Shortlisted**: clear path, satisfied-vs-not state per step, no premature submit, briefing surfaced as step one, brief readable while filling the form.
- **Post-submit / hired / rejected**: each state offers next-step actions instead of dead air.
- **Across all states**: a single visual spine (hero → status strip → action → brief) instead of tabs and conditional layout shifts.

## What it costs

| | Effort |
|---|---|
| Hero + status strip + accordion shell | ~0.5 day |
| Shortlisted checklist (replaces ExtendedApplicationForm) | ~1 day |
| Hired / rejected / applied state panels | ~0.5 day |
| State badges on role cards (dashboard) | ~0.5 day |
| Visual polish + a11y pass | ~0.5 day |
| **Total** | **~3 days** |

Cheaper than I'd guessed because most server-side data is already exposed via `ModelRoleViewModel` and we just shipped Mux upload state plumbing that makes "Processing… / Ready" trivial to render.

## Decisions

1. **Briefing-read** is tracked server-side. Adds a `brief_acknowledged_at` timestamp on `listings`; the client/admin can see who's actually opened the brief.
2. **No contract document** exists. Hired state drops the "Contract" button. Keep shoot info, "Add to calendar", "Contact production" (mailto from booking email).
3. **No similar-roles list** available. Rejected state drops "Browse similar roles." Keep "Refresh portfolio" prompt if the portfolio is stale; otherwise the state is just acknowledgment.
4. **Un-pass requires a confirm.** Tapping "You passed on this role" pops a small confirm dialog ("Reconsider this role?" / "Yes, apply" + "Cancel") before flipping `passed_at` to null.
5. **Status strip is sticky** on scroll (compact form once the hero is out of view).

---

## Build order

1. **Shortlisted state** — replaces `ExtendedApplicationForm` with the numbered checklist + per-step state + gated CTA. Highest user impact; reuses the Mux upload plumbing we just shipped.
2. **Page shell** — hero, sticky status strip, brief accordion, footer cleanup.
3. **Applied / hired / rejected / passed** state panels.
4. **`brief_acknowledged_at` migration + endpoint** to persist the briefing-read checkbox.
5. **Dashboard role-card status pills.**
