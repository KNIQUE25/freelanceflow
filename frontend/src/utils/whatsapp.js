export function getWhatsAppUrl(phone) {
  const digits = String(phone || '').replace(/\D/g, '')

  if (!digits) {
    return null
  }

  const normalized = digits.startsWith('0')
    ? `254${digits.slice(1)}`
    : digits

  if (normalized.length < 10) {
    return null
  }

  return `https://wa.me/${normalized}`
}
