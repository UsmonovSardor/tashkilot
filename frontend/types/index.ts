// ─── Auth ──────────────────────────────────────────────────────────────────────
export type UserRole   = 'client' | 'companion' | 'driver' | 'admin'
export type UserStatus = 'active' | 'suspended' | 'pending_verification'

export interface User {
  id:            number
  email:         string
  role:          UserRole
  status:        UserStatus
  emailVerified: boolean
  profile?:      UserProfile
  createdAt:     string
}

export interface UserProfile {
  firstName:   string
  lastName:    string
  avatarUrl?:  string
  bio?:        string
  gender?:     'male' | 'female' | 'prefer_not_to_say'
  dateOfBirth?: string
  nationality?: string
  city?:        string
  country:      string
}

// ─── Companion ─────────────────────────────────────────────────────────────────
export type AvailabilityStatus = 'available' | 'busy' | 'on_assignment' | 'inactive'
export type Proficiency        = 'native' | 'fluent' | 'conversational' | 'basic'
export type SkillCategory      = 'social' | 'business' | 'cultural' | 'creative'

export interface CompanionLanguage {
  id:          number
  language:    string
  proficiency: Proficiency
}

export interface CompanionSkill {
  id:              number
  skillName:       string
  category:        SkillCategory
  description:     string
  yearsExperience: number
}

export interface CompanionPhoto {
  id:           number
  originalUrl:  string
  blurredUrl:   string
  thumbnailUrl: string
  isPrimary:    boolean
  isVerified:   boolean
}

export interface Companion {
  id:                 number
  userId:             number
  age:                number
  isVerified:         boolean
  isFeatured:         boolean
  photosBlurred:      boolean
  hourlyRate:         number
  halfDayRate?:       number
  fullDayRate?:       number
  availabilityStatus: AvailabilityStatus
  rating:             number
  totalReviews:       number
  totalBookings:      number
  headline?:          string
  fullBio?:           string
  eventTypes:         string[]
  matchScore?:        number  // from AI matching
  user:               { profile: UserProfile }
  languages:          CompanionLanguage[]
  skills:             CompanionSkill[]
  photos:             CompanionPhoto[]
}

// ─── Venue ─────────────────────────────────────────────────────────────────────
export type VenueType = 'vip_lounge' | 'rooftop_terrace' | 'boardroom' | 'private_villa' | 'yacht' | 'penthouse' | 'ballroom'
export type SlotStatus = 'available' | 'reserved' | 'booked' | 'blocked'

export interface VenueAmenity {
  id:   number
  name: string
  icon: string
}

export interface VenueAddon {
  id:          number
  name:        string
  description: string
  price:       number
  pricingType: 'flat' | 'per_person' | 'per_hour'
}

export interface VenueSlot {
  id:            number
  venueId:       number
  date:          string
  startTime:     string
  endTime:       string
  status:        SlotStatus
  priceOverride: number | null
}

export interface Venue {
  id:                number
  name:              string
  type:              VenueType
  description:       string
  shortDescription:  string
  address:           string
  city:              string
  latitude?:         number
  longitude?:        number
  capacityMin:       number
  capacityMax:       number
  basePricePerHour:  number
  basePriceHalfDay:  number
  basePriceFullDay:  number
  currency:          string
  images:            string[]
  coverImageUrl:     string
  rating:            number
  totalReviews:      number
  isActive:          boolean
  isFeatured:        boolean
  amenities:         VenueAmenity[]
  addons:            VenueAddon[]
}

// ─── Fleet ─────────────────────────────────────────────────────────────────────
export type VehicleCategory = 'ultra_luxury' | 'luxury' | 'suv' | 'limousine' | 'sports'
export type VehicleStatus   = 'available' | 'on_trip' | 'maintenance' | 'reserved'

export interface Vehicle {
  id:                   number
  make:                 string
  model:                string
  year:                 number
  color:                string
  licensePlate:         string
  category:             VehicleCategory
  passengerCapacity:    number
  hourlyRate:           number
  dailyRate?:           number
  airportTransferRate?: number
  coverImageUrl:        string
  images:               string[]
  features:             string[]
  status:               VehicleStatus
  rating:               number
}

export interface Driver {
  id:              number
  userId:          number
  vehicleId?:      number
  licenseNumber:   string
  experienceYears: number
  rating:          number
  totalTrips:      number
  languages:       string[]
  isAvailable:     boolean
  isVerified:      boolean
  avatarUrl?:      string
  bio?:            string
  certifications:  string[]
  user:            { profile: UserProfile }
}

// ─── Booking ───────────────────────────────────────────────────────────────────
export type BookingType = 'companion' | 'venue' | 'fleet' | 'package'
export type BookingStatus = 'pending' | 'confirmed' | 'in_progress' | 'completed' | 'cancelled_client' | 'cancelled_provider' | 'disputed'

export interface Booking {
  id:              number
  reference:       string
  clientId:        number
  bookingType:     BookingType
  bookableType:    string
  bookableId:      number
  driverId?:       number
  startsAt:        string
  endsAt:          string
  durationHours:   number
  baseAmount:      number
  addonsAmount:    number
  serviceFee:      number
  taxAmount:       number
  totalAmount:     number
  currency:        string
  status:          BookingStatus
  specialRequests?: string
  eventDetails?:   Record<string, unknown>
  addons:          BookingAddon[]
}

export interface BookingAddon {
  id:         number
  addonName:  string
  category:   string
  quantity:   number
  unitPrice:  number
  totalPrice: number
}

// ─── Payment & Escrow ──────────────────────────────────────────────────────────
export type PaymentStatus = 'pending' | 'processing' | 'captured' | 'failed' | 'refunded' | 'partially_refunded'
export type EscrowState   = 'holding' | 'releasing' | 'released' | 'refunding' | 'refunded' | 'disputed' | 'resolved'

export interface Payment {
  id:               number
  bookingId:        number
  payerId:          number
  amount:           number
  currency:         string
  status:           PaymentStatus
  paymentMethod:    string
  gatewayPaymentId: string
  capturedAt?:      string
}

export interface EscrowTransaction {
  id:                   number
  paymentId:            number
  bookingId:            number
  providerId:           number
  heldAmount:           number
  platformFee:          number
  providerPayout:       number
  state:                EscrowState
  heldAt:               string
  releaseScheduledAt?:  string
  releasedAt?:          string
  refundedAt?:          string
  stripeTransferId?:    string
  stripeRefundId?:      string
  adminNotes?:          string
}

// ─── API Responses ─────────────────────────────────────────────────────────────
export interface PaginatedResponse<T> {
  data:         T[]
  currentPage:  number
  lastPage:     number
  perPage:      number
  total:        number
}

export interface ApiError {
  message: string
  errors?: Record<string, string[]>
}
