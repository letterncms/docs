// admin/src/index.tsx
import { invalidate, plural, registry, t, useAbility, type Entry } from '@letterncms/sdk'
import { Widget, WidgetRow } from '@letterncms/ui'
import { useEffect } from 'react'

function ReadingTimePanel({ entry }: { entry: Entry | null }) {
  const estimate = useAbility<{ words: number; minutes: number }>('reading-time/estimate', { id: entry?.id ?? '' }, { enabled: !!entry })

  // Re-estimate after every save.
  useEffect(() => invalidate('reading-time/'), [entry?.updatedAt])

  if (!entry || !estimate.data) return null

  return (
    <div className="p-4 text-sm text-text">
      <p className="m-0 text-2xl font-semibold text-ink">{t('{minutes} min', { minutes: estimate.data.minutes })}</p>
      <p className="m-0 mt-1 text-muted">{plural(estimate.data.words, '{count} word', '{count} words')}</p>
    </div>
  )
}

registry.panels.set('reading-time', { slot: 'entry.sidebar', label: t('Reading time'), icon: 'clock', component: ReadingTimePanel })

interface Longest {
  average: number | null
  entries: { id: string; collection: string; title: string; minutes: number }[]
}

// A home-screen widget: <Widget> draws the header, loading, error and empty states.
function LongestReads() {
  const longest = useAbility<Longest>('reading-time/longest', { limit: 5 })
  const average = longest.data?.average

  return (
    <Widget
      query={longest}
      action={average != null && <span className="text-xs text-faint">{t('{minutes} min on average', { minutes: average })}</span>}
      empty={longest.data?.entries.length === 0 && { icon: 'clock', title: t('Nothing published yet') }}
    >
      {longest.data?.entries.map((e) => (
        <WidgetRow key={e.id} to={`/content/${e.collection}/${e.id}`} icon="file-text" title={e.title} meta={t('{minutes} min', { minutes: e.minutes })} />
      ))}
    </Widget>
  )
}

registry.widgets.set('reading-time-longest', LongestReads)
