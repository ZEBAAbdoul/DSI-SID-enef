<x-admin>
    @section('title','Tableau de bord')
    <x-dashboard
        :stats="$stats"
        :prochainesSessions="$prochainesSessions"
        :formationsPopulaires="$formationsPopulaires"
        :inscriptionsParMois="$inscriptionsParMois"
    />
</x-admin>