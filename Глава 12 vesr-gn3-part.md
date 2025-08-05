# Глава 12. Настройка динамических туннелей между филиалами. Настройка туннелей DMVPN c использованием протокола динамической маршрутизации OSPF.

Цель этой работы -- Организовать сеть туннелей hub-to-spoke где
маршрутизация будет OSPG поверх mGRE, показать метод организации
динамических тоннелей типа Hub-to-Spoke ( центральный узел-филиал на
спице) с помощью протоколов mGRE+NHRP+OSPF+IPSEC.

Решение.

Для этой работы будем использовать схему сети и конфигурации
маршрутизаторов из предыдущей главы. Описание и назначение протоколов
было описано в предыдущих главах.

![Рис12-1](https://raw.githubusercontent.com/ptah57/Book_vesr-gns3/main/Рис12-1.png)

Рисунок 12-1. Схема динамических туннелей mGRE+NHRP_OSPF+IPSEC.

HUB -- это DMVPN-cервер (NHS), а филиалы -- DMPVN-клиенты (NHC).

### Подготовка к работе:

Для простоты работать будем с одной автономной системой с номером
0.0.0.0 и используем уже настроеннуюй конфигурацию маршрутизаторов.
Менять будет настройка туннелей, добавится роутер OSPF правило для зоны
UNTRAST self.

Убираем последовательно из настройки маршрутизатора vesr124-2-1 всё ,
что связано с протоколом BGP, начиная с описания роутера, затем правило
для пропуска пакетов в зону UNTRAST, политику фильтрации и логгирования:

vesr124-2-1(config)# no router bgp 65005

vesr124-2-1(config)# do commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-22T09:22:02+00:00 %CLI-I-CRIT: user admin from console input: do
commit

vesr124-2-1(config)# do confirm

Configuration has been confirmed. Commit timer canceled.

2025-07-22T09:22:12+00:00 %CLI-I-CRIT: user admin from console input: do
confirm

vesr124-2-1(config)#

vesr124-2-1(config)# security zone-pair UNTRUST self

vesr124-2-1(config-security-zone-pair)# no rule 11

vesr124-2-1(config-security-zone-pair)# exit

vesr124-2-1(config)# do commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-22T09:24:56+00:00 %CLI-I-CRIT: user admin from console input: do
commit

vesr124-2-1(config)#

vesr124-2-1(config)# no route-map PERMIT_ALL

vesr124-2-1(config)# no object-group service to_bgp

vesr124-2-1(config)# no router bgp log-neighbor-changes

vesr124-2-1(config)# do commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-22T09:24:56+00:00 %CLI-I-CRIT: user admin from console input: do
commit

vesr124-2-1(config)# do confirm

Configuration has been confirmed. Commit timer canceled.

2025-07-22T09:27:12+00:00 %CLI-I-CRIT: user admin from console input: do
confirm

vesr124-2-1(config)# no object-group service to_bgp

vesr124-2-1(config)# exit

Warning: you have uncommitted configuration changes.

vesr124-2-1# commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-25T07:15:54+00:00 %CLI-I-CRIT: user admin from console input:
commit

vesr124-2-1# confirm

Configuration has been confirmed. Commit timer canceled.

2025-07-25T07:15:58+00:00 %CLI-I-CRIT: user admin from console input:
confirm

vesr124-2-1#

vesr124-2-1(config)#exit

vesr124-2-1# sh run \| i (bgp \| map)

vesr124-2-1#

Все чисто.

Так же чистим конфигурации маршрутизаторов в филиалах:

- Первый филиал.

vesr124-2-2# sh run \| i (bgp\|map)

object-group service to_bgp

route-map PERMIT_ALL

router bgp log-neighbor-changes

router bgp 65008

route-map PERMIT_ALL out

ip nhrp map 192.168.100.1 10.10.10.2

match destination-port object-group to_bgp

vesr124-2-2#

vesr124-2-2# config

vesr124-2-2(config)# no router bgp 65008

vesr124-2-2(config)# security zone-pair UNTRUST self

vesr124-2-2(config-security-zone-pair)# no rule 11

vesr124-2-2(config-security-zone-pair)# exit

vesr124-2-2(config)#

vesr124-2-2(config)# no route-map PERMIT_ALL

vesr124-2-2(config)# no object-group service to_bgp

vesr124-2-2(config)# do commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-22T10:06:55+00:00 %CLI-I-CRIT: user admin from console input: do
commit

vesr124-2-2(config)# do confirm

Configuration has been confirmed. Commit timer canceled.

2025-07-22T10:07:05+00:00 %CLI-I-CRIT: user admin from console input: do
confirm

vesr124-2-2(config)# do sh run \| i (bgp\|map)

router bgp log-neighbor-changes

ip nhrp map 192.168.100.1 10.10.10.2

vesr124-2-2(config)# no router bgp log-neighbor-changes

vesr124-2-2(config)# do commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-22T10:07:45+00:00 %CLI-I-CRIT: user admin from console input: do
commit

vesr124-2-2(config)# do confirm

Configuration has been confirmed. Commit timer canceled.

2025-07-22T10:07:49+00:00 %CLI-I-CRIT: user admin from console input: do
confirm

vesr124-2-2(config)#

- Второй филиал.

vesr124-2-4# config

vesr124-2-4(config)# no router bgp 65004

vesr124-2-4(config)# security zone-pair UNTRUST self

vesr124-2-4(config-security-zone-pair)# no rule 11

vesr124-2-4(config-security-zone-pair)# exit

vesr124-2-4(config)# no route-map PERMIT_ALL

vesr124-2-4(config)# no object-group service to_bgp

vesr124-2-4(config)# do commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-22T10:19:33+00:00 %CLI-I-CRIT: user admin from console input: do
commit

vesr124-2-4(config)# do confirm

Configuration has been confirmed. Commit timer canceled.

2025-07-22T10:19:39+00:00 %CLI-I-CRIT: user admin from console input: do
confirm

vesr124-2-4(config)# exit

vesr124-2-4# sh run \| i (bgp\|map)

router bgp log-neighbor-changes

ip nhrp map 192.168.100.1 10.10.10.2

vesr124-2-4#

### Настройка маршрутизатора центрального офиса:

При использовании схемы DMVPN необходимо, чтобы HUB являлся
DR-маршрутизатором. Таким образом, маршруты локальных подсетей первого
филиала и второго филиала будут ретранслироваться через маршрутизатор
центрального офиса ( hub).

Подключение маршрутизатора центрального офиса через его внешний IP-адрес
--- 10.10.10.2;\
подключение первого филиала и его внешний IP-адрес --- 10.10.20.2;\
подключение второго филиала и его внешний IP-адрес --- 10.10.30.2.

Параметры IPsec VPN такие же, какие были в предыдущих работах:

IKE:

- группа Диффи-Хэллмана: 2;

- алгоритм шифрования: AES128;

- алгоритм аутентификации: MD5.

IPsec:

- группа Диффи-Хэллмана: 2;

- алгоритм шифрования: AES128;

- алгоритм аутентификации: MD5.

> Настраивается протокол OSPF на маршрутизаторе центрального офиса:

vesr124-2-1# config

vesr124-2-1(config)# router ospf log-adjacency-changes

vesr124-2-1(config)# router ospf 1

vesr124-2-1(config-ospf)# area 0.0.0.0

vesr124-2-1(config-ospf-area)# network 172.16.1.0/24

vesr124-2-1(config-ospf-area)# network 172.16.2.0/24

vesr124-2-1(config-ospf-area)# network 172.16.3.0/24

vesr124-2-1(config-ospf-area)# network 192.168.100.0/24

vesr124-2-1(config-ospf-area)# enable

vesr124-2-1(config-ospf-area)# exit

vesr124-2-1(config-ospf)# enable

vesr124-2-1(config-ospf)# exit

vesr124-2-1(config)# do commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-22T11:47:16+00:00 %CLI-I-CRIT: user admin from console input: do
commit

vesr124-2-1(config)# do confirm

Configuration has been confirmed. Commit timer canceled.

2025-07-22T11:47:23+00:00 %CLI-I-CRIT: user admin from console input: do
confirm

vesr124-2-1(config)#

Настройку зон безопасности не меняем, оставляем как было настроено для
предыдущей работы. Добавляем пропуск пакетов протоколов OSPF, IPSEC over
gre:

vesr124-2-1# config

vesr124-2-1(config)# object-group service ISAKMP_PORT

vesr124-2-1(config-object-group-service)# port-range 500

vesr124-2-1(config-object-group-service)# port-range 4500

vesr124-2-1(config-object-group-service)# exit

vesr124-2-1(config)# security zone-pair UNTRUST self

vesr124-2-1(config-security-zone-pair)# rule 11

vesr124-2-1(config-security-zone-pair-rule)# action permit

vesr124-2-1(config-security-zone-pair-rule)# match protocol udp

vesr124-2-1(config-security-zone-pair-rule)# match destination-port
object-group

ISAKMP_PORT

vesr124-2-1(config-security-zone-pair-rule)# enable

vesr124-2-1(config-security-zone-pair-rule)# exit

vesr124-2-1(config-security-zone-pair)# rule 12

vesr124-2-1(config-security-zone-pair-rule)# action permit

vesr124-2-1(config-security-zone-pair-rule)# match protocol ospf

vesr124-2-1(config-security-zone-pair-rule)# enable

vesr124-2-1(config-security-zone-pair-rule)# exit

vesr124-2-1(config-security-zone-pair)# exit

vesr124-2-1(config)# exit

vesr124-2-1# commit

Configuration has been successfully applied and saved to flash. Commit
timer started, changes will be reverted in 600 seconds.

2025-07-22T13:52:35+00:00 %CLI-I-CRIT: user admin from console input:
commit

vesr124-2-1# confirm

Configuration has been confirmed. Commit timer canceled.

2025-07-22T13:52:39+00:00 %CLI-I-CRIT: user admin from console input:
confirm

vesr124-2-1#

Настроим GRE-туннель, определим принадлежность к зоне безопасности,
настроим OSPF на GRE-туннеле, настроим NHRP и включим туннель и NHRP
командой enable. Чтобы HUB стал DR, необходимо выставить максимальный
приоритет:

Полный текст главы 12 на Бусти - [![Кнопка доната](https://img.shields.io/badge/Загрузить_текст_с-Boosty-6c5ce7)](https://boosty.to/rinatxf/posts/ee537c9e-acc0-46aa-92e8-17018c876cc3?share=post_link)

### **Сводка или ключевые выводы главы** 

В данной главе мы успешно развернули программно-эмуляционный
маршрутизатор vESR в среде GNS3. В результате:

Изучена процедура настройки динамических туннелей на основе протоколов
mGRE+OSPF+IPSEC в GNS3;

Проведена настройка базовых сетевых параметров (адресация, порты и
проведено удаление предыдущих настроек из главы про eBGP ;

Настроен маршрутизатор центрального офиса в качестве узла Hub DMVPN;

Настроен маршрутизатор первого филилала в качестве узла Spoke-1 DMVPN;

Настроен маршрутизатор второго филилала в качестве узла Spoke-2 DMVPN;

Реализована связность между виртуальной лабораторией и реальной сетью;

Сделана диагностика неисправности работы протокола OSPF между
Spoke-to-HUB;

Сделан вывод о необходимости принудительного включения режима
многоадресной рассылки HELLO пакетов в настройках туннеля gre на SPOKE
маршрутизаторах и режима redirect на Hub сервер -  **ip nhrp
redirect** --- это включение ответов перенаправления на NHS, аналогичных
ICMP перенаправлениям, за исключением того, что это управляется
протоколом NHRP. Эта настройка позволяет SPOKE клиентам (спицам)
общаться друг с другом напрямую. ;

Проверена корректная работа протоколов и связности сетей;

Создана основа для построения виртуальных лабораторий с использованием
vESR в дальнейшем моделировании сетей;

Эти действия заложили фундамент для последующих экспериментов с
маршрутизацией, туннелями, VPN и безопасностью на базе маршрутизаторов
Eltex vESR.

В следующей главе вы узнаете как настраивается L2TPv3 туннель.
