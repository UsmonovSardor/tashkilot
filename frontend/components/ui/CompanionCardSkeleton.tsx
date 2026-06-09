export default function CompanionCardSkeleton() {
  return (
    <div className="overflow-hidden rounded-sm bg-elevated border border-border">
      <div className="aspect-[3/4] skeleton" />
      <div className="p-4 space-y-3">
        <div className="skeleton h-3 w-2/3 rounded-sm" />
        <div className="skeleton h-2 w-1/2 rounded-sm" />
        <div className="flex gap-2">
          <div className="skeleton h-4 w-14 rounded-sm" />
          <div className="skeleton h-4 w-14 rounded-sm" />
          <div className="skeleton h-4 w-14 rounded-sm" />
        </div>
      </div>
    </div>
  )
}
