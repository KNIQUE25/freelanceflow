import { defineStore } from 'pinia'
import { getBusinessProfile, createBusinessProfile, updateBusinessProfile, deleteBusinessProfile } from '../services/businessProfile'

export const useBusinessProfileStore = defineStore('businessProfile', {
  state: () => ({ profile: null, isLoading: false }),
  actions: {
    async fetchProfile() { this.isLoading = true; try { const data = await getBusinessProfile(); this.profile = data; return { success: true, data } } catch (e) { return { success: false, message: e.response?.data?.message || 'Unable to load business profile.' } } finally { this.isLoading = false } },
    async create(data) { try { const response = await createBusinessProfile(data); this.profile = response; return { success: true, data: response } } catch (e) { return { success: false, message: e.response?.data?.message || 'Unable to create business profile.' } } },
    async update(id, data) { try { const response = await updateBusinessProfile(id, data); this.profile = response; return { success: true, data: response } } catch (e) { return { success: false, message: e.response?.data?.message || 'Unable to update business profile.' } } },
    async delete(id) { try { await deleteBusinessProfile(id); this.profile = null; return { success: true } } catch (e) { return { success: false, message: e.response?.data?.message || 'Unable to delete business profile.' } } },
  },
})
